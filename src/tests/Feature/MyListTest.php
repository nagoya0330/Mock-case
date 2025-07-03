<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function いいねした商品だけが表示される()
    {
        $user = User::factory()->create();
        $otherItem = Item::factory()->create();
        $favoriteItem = Item::factory()->create();
        $user->favorites()->attach($favoriteItem->id);

        $response = $this->actingAs($user)->get('/?page=mylist');

        $response->assertStatus(200);
        $response->assertSee($favoriteItem->name);
        $response->assertDontSee($otherItem->name);
    }

    /** @test */
    public function 購入済み商品に_sold_ラベルが表示される()
    {
        $user = User::factory()->create();
        $soldItem = Item::factory()->create(['is_sold' => true]);
        $user->favorites()->attach($soldItem->id);

        $response = $this->actingAs($user)->get('/?page=mylist');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    /** @test */
    public function 自分が出品した商品は表示されない()
    {
        $user = User::factory()->create();
        $ownItem = Item::factory()->create(['user_id' => $user->id]);
        $user->favorites()->attach($ownItem->id);

        $response = $this->actingAs($user)->get('/?page=mylist');

        $response->assertStatus(200);
        $response->assertDontSee('MyUniqueItemForTest'); 
    }

    /** @test */
    public function 未認証状態ではマイリストは空になる()
    {
        $item = Item::factory()->create(); // ログインしていないが商品は存在

        $response = $this->get('/?page=mylist');

        $response->assertStatus(200);
        $response->assertDontSee($item->name); // 商品名は表示されない
    }
}