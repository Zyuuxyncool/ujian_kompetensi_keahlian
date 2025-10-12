
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // akun login kurir
            $table->foreignId('shipper_sub_id')->constrained('shipper_subs')->cascadeOnDelete(); // sub-shipper
            $table->string('name'); // nama kurir
            $table->string('phone')->nullable(); // nomor kontak kurir
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('radius')->default(0);
            $table->smallInteger('status')->default(1); // 1=aktif, 0=nonaktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
