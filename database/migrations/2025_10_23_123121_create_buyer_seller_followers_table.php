<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('buyer_seller_followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id');   
            $table->unsignedBigInteger('seller_id');
            $table->timestamps();
            
            $table->unique(['buyer_id', 'seller_id']);
            $table->foreign('buyer_id')->references('id')->on('profil_buyers')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('profil_sellers')->onDelete('cascade');
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_seller_followers');
    }
};
