<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingFieldsToPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('shipping_postal_code')->nullable()->after('item_id');
            $table->string('shipping_address')->nullable()->after('shipping_postal_code');
            $table->string('shipping_building')->nullable()->after('shipping_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('shipping_postal_code');
            $table->dropColumn('shipping_address');
            $table->dropColumn('shipping_building');
        });
    }
}