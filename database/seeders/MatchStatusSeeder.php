<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\MatchStatus;
use Illuminate\Database\Seeder;

class MatchStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['open', 'full', 'finished', 'cancelled'];

        foreach ($statuses as $name) {
            MatchStatus::query()->firstOrCreate(['name' => $name]);
        }
    }
}

