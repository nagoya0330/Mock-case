<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Item;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test 出品情報が正しく保存される
     */
    public function 出品情報が正しく保存される()
{
    Storage::fake('public');

    $user = User::factory()->create();
    $category = Category::factory()->create();

    $file = UploadedFile::fake()->create('sample.jpg', 100, 'image/jpeg');

    $response = $this->actingAs($user)->post('/sell', [
        'name' => 'テスト商品',
        'brand_name' => 'ブランド名',
        'description' => '商品の説明です',
        'condition' => '新品',
        'price' => 9999,
        'categories' => [$category->id],
        'image' => $file,
    ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect('/');

    // 登録されたアイテム取得
    $item = \App\Models\Item::first();

    $this->assertNotNull($item, 'アイテムが保存されていません。保存処理に失敗している可能性があります。');

    $this->assertDatabaseHas('items', [
        'id' => $item->id,
        'name' => 'テスト商品',
        'brand_name' => 'ブランド名',
        'description' => '商品の説明です',
        'condition' => '新品',
        'price' => 9999,
        'user_id' => $user->id,
    ]);

    $this->assertDatabaseHas('item_category', [
        'item_id' => $item->id,
        'category_id' => $category->id,
    ]);

    Storage::disk('public')->assertExists('items/' . $file->hashName());

    $response->assertRedirect('/');
}
}