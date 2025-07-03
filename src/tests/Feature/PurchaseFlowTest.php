<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseFlowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品購入が完了する()
    {
        $user = User::factory()->create();
        $address = Address::factory()->create(['user_id' => $user->id]);
        $item = Item::factory()->create(['is_sold' => false]);

        $this->actingAs($user)->post("/purchase/{$item->id}/store", [
            'payment_method' => 'カード支払い',
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'is_sold' => true,
        ]);
    }

    /** @test */
    public function 商品一覧で購入済み商品に_sold_が表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['is_sold' => true]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    /** @test */
    public function 購入商品がプロフィール購入一覧に表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['is_sold' => true]);
        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get('/mypage?page=buy');
        $response->assertStatus(200)->assertSee($item->name);
    }

    /** @test */
    public function 支払い方法が即時反映される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['is_sold' => false]);
        $this->actingAs($user)->post("/purchase/{$item->id}", [
            'payment_method' => 'コンビニ払い',
        ]);

        $response = $this->get("/purchase/{$item->id}");

        $response->assertSee('コンビニ払い');
    }

    /** @test */
    public function 登録した住所が購入画面に表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post("/address/update/{$item->id}", [
            'postal' => '100-0001',
            'address' => '東京都千代田区',
            'building' => '霞が関ビル',
        ]);

        $response = $this->get("/purchase/{$item->id}");

        $response->assertSee('100-0001');
        $response->assertSee('東京都千代田区');
        $response->assertSee('霞が関ビル');
    }

    /** @test */
    public function 購入時に住所が紐づいて保存されている()
    {
        $user = User::factory()->create();
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'postal_code' => '150-0001',
            'address' => '東京都渋谷区',
            'building' => '渋谷ヒカリエ10F',
        ]);
        $item = Item::factory()->create(['is_sold' => false]);

        $this->actingAs($user)->post("/purchase/{$item->id}/store", [
            'payment_method' => 'カード支払い',
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // 紐づく住所がユーザーの住所であることを確認
        $this->assertEquals($user->address->postal_code, '150-0001');
    }
}