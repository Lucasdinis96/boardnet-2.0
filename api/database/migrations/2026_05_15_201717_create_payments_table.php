<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('negotiation_id')->constrained()->cascadeOnDelete();
            $table->string('provider');
            $table->string('payment_method');
            $table->string('status')->default('pending')->index();
            $table->decimal('amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->integer('installments')->nullable();
            $table->string('currency')->default('BRL');
            $table->string('provider_payment_id')->nullable()->index();
            $table->string('transaction_id')->nullable();
            $table->text('payment_url')->nullable();
            $table->json('provider_response')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
