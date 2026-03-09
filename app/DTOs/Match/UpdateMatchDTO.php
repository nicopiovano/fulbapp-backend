<?php

declare(strict_types=1);

namespace App\DTOs\Match;

final class UpdateMatchDTO
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $date = null,
        public readonly ?string $time = null,
        public readonly ?float $price = null,
        public readonly ?string $pitchType = null,
        public readonly ?int $playersCount = null,
        public readonly ?int $openSlots = null,
        public readonly ?string $venueName = null,
        public readonly ?string $neighborhood = null,
        public readonly ?string $address = null,
        public readonly ?float $lat = null,
        public readonly ?float $lng = null,
        public readonly ?int $footballLevel = null,
        public readonly ?string $gender = null,
        public readonly ?string $fieldSurface = null,
        public readonly ?string $establishmentCovered = null,
        public readonly ?array $establishmentAmenities = null,
        public readonly ?string $description = null,
        public readonly ?int $statusId = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(int $id, array $data): self
    {
        return new self(
            id: $id,
            date: $data['date'] ?? null,
            time: $data['time'] ?? null,
            price: array_key_exists('price', $data) ? ($data['price'] !== null ? (float) $data['price'] : null) : null,
            pitchType: $data['pitch_type'] ?? null,
            playersCount: isset($data['players_count']) ? (int) $data['players_count'] : null,
            openSlots: isset($data['open_slots']) ? (int) $data['open_slots'] : null,
            venueName: $data['venue_name'] ?? null,
            neighborhood: $data['neighborhood'] ?? null,
            address: $data['address'] ?? null,
            lat: isset($data['lat']) ? (float) $data['lat'] : null,
            lng: isset($data['lng']) ? (float) $data['lng'] : null,
            footballLevel: isset($data['football_level']) ? (int) $data['football_level'] : null,
            gender: $data['gender'] ?? null,
            fieldSurface: $data['field_surface'] ?? null,
            establishmentCovered: $data['establishment_covered'] ?? null,
            establishmentAmenities: array_key_exists('establishment_amenities', $data) ? $data['establishment_amenities'] : null,
            description: $data['description'] ?? null,
            statusId: isset($data['status_id']) ? (int) $data['status_id'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $map = [
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
        ];

        return array_filter($map, fn ($v) => $v !== null);
    }
}
