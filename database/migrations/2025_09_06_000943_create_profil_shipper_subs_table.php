<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipper_subs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipper_id')->constrained('profil_shippers')->cascadeOnDelete();
            $table->uuid('uuid')->unique();
            $table->string('name'); // nama sub-shipper atau kecamatan
            $table->string('contact')->nullable(); // nomor/kontak sub-shipper
            $table->text('service_area')->nullable(); // kecamatan/desa yang dilayani
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('radius')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipper_subs');
    }
};
