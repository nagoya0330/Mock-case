<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 全商品を取得できる()
    {
        Item::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeInOrder(
            Item::all()->pluck('name')->toArray()
        );
    }

    /** @test */
    public function 購入済み商品にSoldのラベルが表示される()
    {
        $soldItem = Item::factory()->create([
            'is_sold' => true,
            'name' => 'Sold商品'
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sold');
        $response->assertSee('Sold商品');
    }

    /** @test */
    public function 自分が出品した商品は表示されない()
    {
        $user = User::factory()->create();
        $ownItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の商品'
        ]);
        $otherItem = Item::factory()->create([
            'name' => '他人の商品'
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }

    /** @test */
    public function 商品名で部分一致検索ができる()
    {
        Item::factory()->create(['name' => 'ナイキのスニーカー']);
        Item::factory()->create(['name' => 'アディダスのジャケット']);

        $response = $this->get('/?search=スニーカー');

        $response->assertStatus(200);
        $response->assertSee('ナイキのスニーカー');
        $response->assertDontSee('アディダスのジャケット');
    }

    /** @test */
    public function 検索状態がマイリストでも保持されている()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['name' => 'リスト用商品']);
        $user->favorites()->attach($item->id);

        $response = $this->actingAs($user)->get('/?page=mylist&keyword=リスト');

        $response->assertStatus(200);
        $response->assertSee('リスト用商品');
    }
}
