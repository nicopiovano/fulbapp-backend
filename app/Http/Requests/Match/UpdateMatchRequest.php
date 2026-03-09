<?php

declare(strict_types=1);

namespace App\Http\Requests\Match;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'date'                    => ['sometimes', 'date'],
            'time'                    => ['sometimes', 'date_format:H:i'],
            'price'                   => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'pitch_type'              => ['sometimes', 'in:f5,f7,f8,f9,f11'],
            'players_count'           => ['sometimes', 'integer', 'min:2'],
            'open_slots'              => ['sometimes', 'nullable', 'integer', 'min:1'],
            'venue_name'              => ['sometimes', 'string', 'max:255'],
            'neighborhood'            => ['sometimes', 'nullable', 'string', 'max:100'],
            'address'                 => ['sometimes', 'string', 'max:255'],
            'lat'                     => ['sometimes', 'nullable', 'numeric', 'between:-90,90'],
            'lng'                     => ['sometimes', 'nullable', 'numeric', 'between:-180,180'],
            'football_level'          => ['sometimes', 'integer', 'between:1,10'],
            'gender'                  => ['sometimes', 'in:masculino,femenino,mixto'],
            'field_surface'           => ['sometimes', 'nullable', 'in:cemento,caucho,sintetico'],
            'establishment_covered'   => ['sometimes', 'nullable', 'in:techado,descubierto'],
            'establishment_amenities' => ['sometimes', 'nullable', 'array'],
            'establishment_amenities.*' => ['string', 'in:buffet,vestuario,parrilla'],
            'description'             => ['sometimes', 'nullable', 'string'],
            'status_id'               => ['sometimes', 'integer', 'exists:match_statuses,id'],
        ];
    }
}
