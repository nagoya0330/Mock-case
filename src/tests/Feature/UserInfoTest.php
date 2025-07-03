<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserInfoTest extends TestCase
{
    use RefreshDatabase;

    /**
 * @test プロフィール画像・名前・出品商品・購入商品が表示される
 */
public function ユーザー情報が取得できる()
{
    $user = User::factory()->create(['name' => 'テストユーザー']);

    // 出品商品
    $item = Item::factory()->create(['user_id' => $user->id]);

    // 購入商品（他人が出品したものを購入した体）
    $purchasedItem = Item::factory()->create(['is_sold' => true]);
    Purchase::factory()->create([
        'user_id' => $user->id,
        'item_id' => $purchasedItem->id,
    ]);

    // テスト実行（出品商品タブ）
    $responseSell = $this->actingAs($user)->get('/mypage?page=sell');
    $responseSell->assertStatus(200);
    $responseSell->assertSee('テストユーザー');
    $responseSell->assertSee($item->name); // 出品商品

    // テスト実行（購入商品タブ）
    $responseBuy = $this->actingAs($user)->get('/mypage?page=buy');
    $responseBuy->assertStatus(200);
    $responseBuy->assertSee($purchasedItem->name); // 購入商品
}

    /**
     * @test ユーザー編集画面に過去設定が初期値として表示される
     */
    public function ユーザー情報変更の初期値が表示される()
    {
        $user = User::factory()->create([
        'name' => '旧ユーザー',
        'profile_image' => 'profile_images/sample.jpg', // ← 画像パスを設定
    ]);
        Address::factory()->create([
        'user_id' => $user->id,
        'postal_code' => '123-4567',
        'address' => '東京都港区1-1-1',
        'building' => 'テストビル101'
    ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertSee('旧ユーザー');                 // ユーザー名
        $response->assertSee('123-4567');                  // 郵便番号
        $response->assertSee('東京都港区1-1-1');             // 住所
        $response->assertSee('テストビル101');              // 建物名
        $response->assertSee('profile_images/sample.jpg');  // プロフィール画像
    }
}