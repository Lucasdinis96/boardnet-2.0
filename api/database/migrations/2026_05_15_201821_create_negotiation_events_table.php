<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {

        Schema::create('negotiation_events', function (Blueprint $table) {

            $table->id();

            $table->foreignId('negotiation_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Evento
            |--------------------------------------------------------------------------
            */

            $table->string('event');

            /*
            |--------------------------------------------------------------------------
            | Usuário responsável
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Dados extras
            |--------------------------------------------------------------------------
            */

            $table->json('metadata')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {

        Schema::dropIfExists('negotiation_events');
    }
};