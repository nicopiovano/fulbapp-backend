<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $authId = (int) $request->user()?->id;

        return [
            'id'                      => $this->id,
            'date'                    => $this->date?->toDateString(),
            'time'                    => $this->time,
            'price'                   => $this->price,
            'pitch_type'              => $this->pitch_type,
            'players_count'           => $this->players_count,
            'open_slots'              => $this->open_slots,
            'venue_name'              => $this->venue_name,
            'neighborhood'            => $this->neighborhood,
            'address'                 => $this->address,
            'lat'                     => $this->lat,
            'lng'                     => $this->lng,
            'football_level'          => $this->football_level,
            'gender'                  => $this->gender,
            'field_surface'           => $this->field_surface,
            'establishment_covered'   => $this->establishment_covered,
            'establishment_amenities' => $this->establishment_amenities ?? [],
            'description'             => $this->description,
            'status'                  => $this->whenLoaded('status', fn () => ['name' => $this->status->name]),
            'players'                 => $this->whenLoaded('players', fn () => $this->players->map(fn ($p) => [
                'id'       => $p->id,
                'name'     => $p->name,
                'avatar'   => $p->avatar,
                'age'      => $p->age,
                'position' => $p->position,
            ])),
            'created_by'              => $this->created_by,
            'created_at'              => $this->created_at,
            'updated_at'              => $this->updated_at,

            // Campos contextuales calculados en el servidor
            'is_creator'              => $authId > 0 && (int) $this->created_by === $authId,
        ];
    }
}
