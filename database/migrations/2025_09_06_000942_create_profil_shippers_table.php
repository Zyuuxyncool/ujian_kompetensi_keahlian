
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_shippers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->uuid('uuid')->unique();
            $table->string('photo')->nullable(); // logo perusahaan
            $table->string('company_name'); // nama ekspedisi / kota
            $table->string('code')->unique(); // kode shipper, misal JNE, JNT
            $table->string('contact')->nullable(); // nomor/email kontak
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('radius')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_shippers');
    }
};
