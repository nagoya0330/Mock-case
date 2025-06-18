<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCategoryColumnFromItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('category'); // 元の定義をそのまま
        });
    }
}
