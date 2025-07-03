<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品詳細ページに必要な情報が表示される()
    {
        $item = Item::factory()->create();

        $response = $this->get(route('item.detail', ['item_id' => $item->id]));

        $response->assertStatus(200)
                ->assertSee($item->name)
                ->assertSee(number_format($item->price))
                ->assertSee($item->description);
    }

    /** @test */
    public function 商品の複数カテゴリが表示される()
    {
        $item = Item::factory()->create();
        $category1 = Category::create(['name' => 'カテゴリA']);
        $category2 = Category::create(['name' => 'カテゴリB']);

        $item->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get(route('item.detail', ['item_id' => $item->id]));

        $response->assertSee('カテゴリA')
                ->assertSee('カテゴリB');
    }

    /** @test */
    public function いいねボタンを押すと登録されカウントが増える()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->post(route('favorite.toggle', $item->id));

        $this->assertDatabaseHas('favorite_items', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function いいね済み商品はアイコンが変化して表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $user->favorites()->attach($item->id); // ← ここを修正

        $response = $this->actingAs($user)->get(route('item.detail', $item->id));

        $response->assertSee('❤️');
    }

    /** @test */
    public function いいねを解除するとカウントが減る()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $user->favorites()->attach($item->id);

        $this->actingAs($user)
            ->post(route('favorite.toggle', $item->id)); // いいね解除

        $this->assertDatabaseMissing('favorite_items', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function ログイン済みユーザーがコメントを送信できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('comment.store', $item->id), [
            'content' => 'テストコメント',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
    }

    /** @test */
    public function 未ログインユーザーはコメントを送信できない()
    {
        $item = Item::factory()->create();

        $response = $this->post(route('comment.store', $item->id), [
            'content' => 'テストコメント',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
    }

    /** @test */
    public function コメントが未入力の場合バリデーションエラーになる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('comment.store', $item->id), [
            'content' => '',
        ]);

        $response->assertSessionHasErrors('content');
    }

    /** @test */
    public function コメントが255文字を超えるとバリデーションエラーになる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $longComment = str_repeat('あ', 256);

        $response = $this->actingAs($user)->post(route('comment.store', $item->id), [
            'content' => $longComment,
        ]);

        $response->assertSessionHasErrors('content');
    }
}
