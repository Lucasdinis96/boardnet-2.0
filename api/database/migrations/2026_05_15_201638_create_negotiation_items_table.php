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
        Schema::create('negotiation_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('negotiation_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('trade_item_id')
                ->nullable()
                ->constrained('trade_items')
                ->nullOnDelete();

            $table->foreignId('boardgame_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('price', 10, 2);

            $table->json('boardgame_snapshot');

            $table->string('status')->default('reserved');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negotiations_items');
    }
};
