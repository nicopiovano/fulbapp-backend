<?php

declare(strict_types=1);

namespace App\DTOs\Match;

final class CreateMatchDTO
{
    public function __construct(
        public readonly string $date,
        public readonly string $time,
        public readonly ?float $price,
        public readonly string $pitchType,
        public readonly int $playersCount,
        public readonly ?int $openSlots,
        public readonly string $venueName,
        public readonly ?string $neighborhood,
        public readonly string $address,
        public readonly ?float $lat,
        public readonly ?float $lng,
        public readonly int $footballLevel,
        public readonly string $gender,
        public readonly ?string $fieldSurface,
        public readonly ?string $establishmentCovered,
        public readonly ?array $establishmentAmenities,
        public readonly ?string $description,
        public readonly int $statusId,
        public readonly int $createdBy,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data, int $createdBy, int $statusId): self
    {
        return new self(
            date: $data['date'],
            time: $data['time'],
            price: isset($data['price']) ? (float) $data['price'] : null,
            pitchType: $data['pitch_type'],
            playersCount: (int) $data['players_count'],
            openSlots: isset($data['open_slots']) ? (int) $data['open_slots'] : null,
            venueName: $data['venue_name'],
            neighborhood: $data['neighborhood'] ?? null,
            address: $data['address'],
            lat: isset($data['lat']) ? (float) $data['lat'] : null,
            lng: isset($data['lng']) ? (float) $data['lng'] : null,
            footballLevel: (int) $data['football_level'],
            gender: $data['gender'],
            fieldSurface: $data['field_surface'] ?? null,
            establishmentCovered: $data['establishment_covered'] ?? null,
            establishmentAmenities: $data['establishment_amenities'] ?? null,
            description: $data['description'] ?? null,
            statusId: $statusId,
            createdBy: $createdBy,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'date'                    => $this->date,
            'time'                    => $this->time,
            'price'                   => $this->price,
            'pitch_type'              => $this->pitchType,
            'players_count'           => $this->playersCount,
            'open_slots'              => $this->openSlots,
            'venue_name'              => $this->venueName,
            'neighborhood'            => $this->neighborhood,
            'address'                 => $this->address,
            'lat'                     => $this->lat,
            'lng'                     => $this->lng,
            'football_level'          => $this->footballLevel,
            'gender'                  => $this->gender,
            'field_surface'           => $this->fieldSurface,
            'establishment_covered'   => $this->establishmentCovered,
            'establishment_amenities' => $this->establishmentAmenities,
            'description'             => $this->description,
            'status_id'               => $this->statusId,
            'created_by'              => $this->createdBy,
        ];
    }
}
