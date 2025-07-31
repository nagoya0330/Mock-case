<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ユーザーの作成
        User::factory()->create(['id' => 1, 'name' => 'User1', 'email' => 'user1@example.com']);
        User::factory()->create(['id' => 2, 'name' => 'User2', 'email' => 'user2@example.com']);
        User::factory()->create(['id' => 3, 'name' => 'User3', 'email' => 'user3@example.com']);
        User::factory()->create(['id' => 4, 'name' => 'User4', 'email' => 'user4@example.com']);
        User::factory()->create(['id' => 5, 'name' => 'User5', 'email' => 'user5@example.com']);

        // Seederの呼び出し
        $this->call([
            CategorySeeder::class, // ← これを追加
            ItemSeeder::class,
        ]);
    }
}