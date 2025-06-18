<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'user_id' => 1,
                'name' => '腕時計',
                'brand_name' => 'SEIKO',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'condition' => '良好',
                'price' => 15000,
                'image_path' => 'items/watch.jpg',
                'category_name' => 'ファッション',
                'is_recommended' => true,
            ],
            [
                'user_id' => 2,
                'name' => 'HDD',
                'brand_name' => 'Western Digital',
                'description' => '高速で信頼性の高いハードディスク',
                'condition' => '目立った傷や汚れなし',
                'price' => 5000,
                'image_path' => 'items/hdd.jpg',
                'category_name' => '家電',
                'is_recommended' => false,
            ],
            [
                'user_id' => 1,
                'name' => '玉ねぎ3束',
                'brand_name' => '農家直送',
                'description' => '新鮮な玉ねぎ3束のセット',
                'condition' => 'やや傷や汚れあり',
                'price' => 300,
                'image_path' => 'items/onion.jpg',
                'category_name' => '食品',
                'is_recommended' => false,
            ],
            [
                'user_id' => 3,
                'name' => '革靴',
                'brand_name' => 'REGAL',
                'description' => 'クラシックなデザインの革靴',
                'condition' => '状態が悪い',
                'price' => 4000,
                'image_path' => 'items/shoes.jpg',
                'category_name' => 'ファッション',
                'is_recommended' => false,
            ],
            [
                'user_id' => 4,
                'name' => 'ノートPC',
                'brand_name' => 'DELL',
                'description' => '高性能なノートパソコン',
                'condition' => '良好',
                'price' => 45000,
                'image_path' => 'items/laptop.jpg',
                'category_name' => '家電',
                'is_recommended' => true,
            ],
            [
                'user_id' => 5,
                'name' => 'マイク',
                'brand_name' => 'SHURE',
                'description' => '高音質のレコーディング用マイク',
                'condition' => '目立った傷や汚れなし',
                'price' => 8000,
                'image_path' => 'items/mic.jpg',
                'category_name' => '家電',
                'is_recommended' => false,
            ],
            [
                'user_id' => 2,
                'name' => 'ショルダーバッグ',
                'brand_name' => 'PORTER',
                'description' => 'おしゃれなショルダーバッグ',
                'condition' => 'やや傷や汚れあり',
                'price' => 3500,
                'image_path' => 'items/bag.jpg',
                'category_name' => 'ファッション',
                'is_recommended' => true,
            ],
            [
                'user_id' => 3,
                'name' => 'タンブラー',
                'brand_name' => 'THERMOS',
                'description' => '使いやすいタンブラー',
                'condition' => '状態が悪い',
                'price' => 500,
                'image_path' => 'items/tumbler.jpg',
                'category_name' => 'キッチン用品',
                'is_recommended' => false,
            ],
            [
                'user_id' => 4,
                'name' => 'コーヒーミル',
                'brand_name' => 'HARIO',
                'description' => '手動のコーヒーミル',
                'condition' => '良好',
                'price' => 4000,
                'image_path' => 'items/mill.jpg',
                'category_name' => 'キッチン用品',
                'is_recommended' => true,
            ],
            [
                'user_id' => 5,
                'name' => 'メイクセット',
                'brand_name' => 'CANMAKE',
                'description' => '便利なメイクアップセット',
                'condition' => '目立った傷や汚れなし',
                'price' => 2500,
                'image_path' => 'items/makeup.jpg',
                'category_name' => 'コスメ',
                'is_recommended' => false,
            ],
        ];

        foreach ($items as $data) {
            $item = Item::create([
                'user_id' => $data['user_id'],
                'name' => $data['name'],
                'brand_name' => $data['brand_name'],
                'description' => $data['description'],
                'condition' => $data['condition'],
                'price' => $data['price'],
                'image_path' => $data['image_path'],
                'is_recommended' => $data['is_recommended'],
            ]);

            // カテゴリ名に一致するIDを取得して attach
            $category = Category::where('name', $data['category_name'])->first();
            if ($category) {
                $item->categories()->attach($category->id);
            }
        }
    }
}