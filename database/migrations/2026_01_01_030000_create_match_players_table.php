<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('match_players', function (Blueprint $table): void {
            $table->foreignId('match_id')->constrained('matches')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->primary(['match_id', 'user_id']);
            $table->timestamp('joined_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_players');
    }
};
