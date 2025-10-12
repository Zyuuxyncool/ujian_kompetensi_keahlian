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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('reference')->unique();
            $table->string('provider')->default('qris');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('IDR');
            $table->text('qris_payload')->nullable();
            $table->string('qris_url')->nullable();
            $table->string('provider_transaction_id')->nullable()->unique();
            $table->tinyInteger('status')->default(0); // 0=pending,1=paid,2=failed,3=expired
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamps();
            $table->index(['order_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
