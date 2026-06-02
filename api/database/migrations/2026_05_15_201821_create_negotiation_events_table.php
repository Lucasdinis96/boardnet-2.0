<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {

        Schema::create('negotiation_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('negotiation_id')->constrained()->cascadeOnDelete();
            $table->string('event');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('negotiation_events');
    }
};