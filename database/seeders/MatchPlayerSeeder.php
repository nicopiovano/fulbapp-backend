<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\GameMatch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatchPlayerSeeder extends Seeder
{
    private const USER_MAP = [
        'mock-current' => 2,
        'u1'  => 3,  'u2'  => 4,  'u3'  => 5,
        'u4'  => 6,  'u5'  => 7,  'u6'  => 8,
        'u7'  => 9,  'u8'  => 10, 'u9'  => 11,
        'u10' => 12, 'u11' => 13, 'u12' => 14,
        'u13' => 15, 'u14' => 16, 'u15' => 17, 'u16' => 18,
    ];

    // playerIds del mock en el mismo orden que GameMatchSeeder
    private const MOCK_PLAYER_IDS = [
        ['mock-current', 'u1', 'u2'],           // Cancha Siempre Futura
        ['mock-current', 'u1'],                  // Cancha Los Andes
        ['u2', 'u4', 'u6', 'mock-current'],      // Complejo Deportivo Norte (cancelado)
        ['u1', 'u3', 'u5', 'u6'],               // Estadio Municipal
        ['u4', 'u5'],                            // Cancha Central
        ['mock-current', 'u2', 'u3'],            // Cancha Pasada
        ['u1', 'u2', 'u3', 'u4', 'u5', 'u6', 'mock-current'], // Polideportivo Sur
        ['u1', 'u7', 'u8', 'u9'],               // Cancha Parque Chacabuco
        ['u2', 'u4', 'u10', 'u11', 'u12'],      // Complejo Roca
        ['u3', 'u13', 'u14', 'u15', 'u16'],     // Cancha Palermo
        ['u7', 'u8', 'u9'],                      // Cancha Belgrano
    ];

    public function run(): void
    {
        $matches = GameMatch::query()->orderBy('id')->get();

        foreach ($matches as $index => $match) {
            $mockPlayerIds = self::MOCK_PLAYER_IDS[$index] ?? [];

            foreach ($mockPlayerIds as $mockId) {
                $userId = self::USER_MAP[$mockId] ?? null;

                if (! $userId) {
                    continue;
                }

                DB::table('match_players')->insertOrIgnore([
                    'match_id'  => $match->id,
                    'user_id'   => $userId,
                    'joined_at' => now(),
                ]);
            }
        }
    }
}
