<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddressesTableForSingleAddressField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            // 旧カラムの削除
            $table->dropColumn(['prefecture', 'city', 'street']);

            // 新カラムの追加
            $table->string('address')->after('postal_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            // 新カラムの削除
            $table->dropColumn('address');

            // 旧カラムの復元
            $table->string('prefecture')->after('postal_code');
            $table->string('city')->after('prefecture');
            $table->string('street')->after('city');
        });
    }
}