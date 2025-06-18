<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
        $table->unsignedBigInteger('user_id'); // 出品者
        $table->string('name');
        $table->string('brand_name')->nullable();
        $table->text('description');
        $table->string('condition'); // 商品の状態（良好など）
        $table->unsignedInteger('price');
        $table->string('image_path')->nullable(); // 商品画像の保存パス
        $table->string('category');
        $table->boolean('is_recommended')->default(false); // 「おすすめ」表示用
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
