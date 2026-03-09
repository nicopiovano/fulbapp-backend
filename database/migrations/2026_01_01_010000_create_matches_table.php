<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table): void {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->decimal('price', 10, 2)->nullable();

            // Tipo de partido y capacidad
            $table->string('pitch_type');                    // f5, f7, f8, f9, f11
            $table->unsignedInteger('players_count');        // maxPlayers (capacidad total)
            $table->unsignedInteger('open_slots')->nullable(); // cupos a cubrir vía app

            // Ubicación
            $table->string('venue_name');
            $table->string('neighborhood')->nullable();
            $table->string('address');
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

            // Características del partido
            $table->unsignedTinyInteger('football_level');   // dificultad 1-10
            $table->string('gender');                        // mixto, femenino, masculino

            // Características del establecimiento
            $table->string('field_surface')->nullable();     // cemento, caucho, sintetico
            $table->string('establishment_covered')->nullable(); // techado, descubierto
            $table->jsonb('establishment_amenities')->nullable(); // ['buffet', 'vestuario']

            $table->text('description')->nullable();

            $table->foreignId('status_id')->constrained('match_statuses');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
