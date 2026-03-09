<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Administrador ──────────────────────────────────────────────────────
        User::query()->firstOrCreate(
            ['email' => 'nmpiovano@hotmail.com'],
            [
                'name'     => 'Nicolás Piovano',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=admin',
                'age'      => 28,
                'position' => 'mediocampista',
                'password' => Hash::make('123456'),
            ],
        );

        // ── Jugadores (mismos que el mock del frontend) ────────────────────────
        // El orden importa: los GameMatchSeeder y MatchPlayerSeeder usan estos IDs.
        // id=2: mock-current  id=3: u1  id=4: u2 ... id=18: u16
        $players = [
            // mock-current → el usuario que "sos vos" en la app
            [
                'name'     => 'Yo (Usuario actual)',
                'email'    => 'current@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=current',
                'age'      => 26,
                'position' => 'defensor',
                'password' => Hash::make('password'),
            ],
            // u1
            [
                'name'     => 'Lionel Messi',
                'email'    => 'u1@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=messi',
                'age'      => 37,
                'position' => 'delantero',
                'password' => Hash::make('password'),
            ],
            // u2
            [
                'name'     => 'Marta Vieira',
                'email'    => 'u2@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=marta',
                'age'      => 38,
                'position' => 'delantero',
                'password' => Hash::make('password'),
            ],
            // u3
            [
                'name'     => 'Emiliano Martínez',
                'email'    => 'u3@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=emiliano',
                'age'      => 32,
                'position' => 'arquero',
                'password' => Hash::make('password'),
            ],
            // u4
            [
                'name'     => 'Sergio Ramos',
                'email'    => 'u4@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=ramos',
                'age'      => 38,
                'position' => 'defensor',
                'password' => Hash::make('password'),
            ],
            // u5
            [
                'name'     => 'Luka Modrić',
                'email'    => 'u5@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=modric',
                'age'      => 39,
                'position' => 'mediocampista',
                'password' => Hash::make('password'),
            ],
            // u6
            [
                'name'     => 'Alexia Putellas',
                'email'    => 'u6@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=alexia',
                'age'      => 30,
                'position' => 'mediocampista',
                'password' => Hash::make('password'),
            ],
            // u7
            [
                'name'     => 'Kylian Mbappé',
                'email'    => 'u7@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=mbappe',
                'age'      => 25,
                'position' => 'delantero',
                'password' => Hash::make('password'),
            ],
            // u8
            [
                'name'     => 'Erling Haaland',
                'email'    => 'u8@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=haaland',
                'age'      => 24,
                'position' => 'delantero',
                'password' => Hash::make('password'),
            ],
            // u9
            [
                'name'     => 'Kevin De Bruyne',
                'email'    => 'u9@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=debruyne',
                'age'      => 33,
                'position' => 'mediocampista',
                'password' => Hash::make('password'),
            ],
            // u10
            [
                'name'     => 'Virgil van Dijk',
                'email'    => 'u10@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=vandijk',
                'age'      => 33,
                'position' => 'defensor',
                'password' => Hash::make('password'),
            ],
            // u11
            [
                'name'     => 'Sam Kerr',
                'email'    => 'u11@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=samkerr',
                'age'      => 30,
                'position' => 'delantero',
                'password' => Hash::make('password'),
            ],
            // u12
            [
                'name'     => 'Neymar Jr',
                'email'    => 'u12@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=neymar',
                'age'      => 32,
                'position' => 'delantero',
                'password' => Hash::make('password'),
            ],
            // u13
            [
                'name'     => 'Gianluigi Buffon',
                'email'    => 'u13@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=buffon',
                'age'      => 46,
                'position' => 'arquero',
                'password' => Hash::make('password'),
            ],
            // u14
            [
                'name'     => 'Lucy Bronze',
                'email'    => 'u14@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=lucybronze',
                'age'      => 32,
                'position' => 'defensor',
                'password' => Hash::make('password'),
            ],
            // u15
            [
                'name'     => 'Rodri',
                'email'    => 'u15@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=rodri',
                'age'      => 27,
                'position' => 'mediocampista',
                'password' => Hash::make('password'),
            ],
            // u16
            [
                'name'     => 'Ada Hegerberg',
                'email'    => 'u16@fulbapp.com',
                'avatar'   => 'https://api.dicebear.com/7.x/avataaars/svg?seed=adahegerberg',
                'age'      => 29,
                'position' => 'delantero',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($players as $data) {
            User::query()->firstOrCreate(['email' => $data['email']], $data);
        }
    }
}
