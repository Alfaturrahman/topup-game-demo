<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->after('player_id');
            $table->boolean('status_pengiriman')->default(false)->after('status');
            $table->string('bukti_pengiriman')->nullable()->after('status_pengiriman');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id', 'status_pengiriman', 'bukti_pengiriman']);
        });
    }

};
