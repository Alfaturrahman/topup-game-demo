<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('topups', function (Blueprint $table) {
            $table->id();
            $table->string('player_id');             // ID game user
            $table->string('amount');                // Contoh: 100m, 1b, 3b
            $table->integer('price');                // Harga dalam rupiah
            $table->string('payment_method');        // Contoh: qris, dana, bri
            $table->string('merchant_ref')->unique(); // Kode unik transaksi
            $table->string('status')->default('pending'); // pending, paid, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topups');
    }
};
