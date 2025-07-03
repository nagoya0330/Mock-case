<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'postal_code' => '150-0001',
            'address' => '東京都渋谷区',
            'building' => '渋谷ヒカリエ10F',
        ];
    }
}
