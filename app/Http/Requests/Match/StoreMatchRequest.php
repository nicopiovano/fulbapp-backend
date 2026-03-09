<?php

declare(strict_types=1);

namespace App\Http\Requests\Match;

use Illuminate\Foundation\Http\FormRequest;

class StoreMatchRequest extends FormRequest
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
            'date'                    => ['required', 'date'],
            'time'                    => ['required', 'date_format:H:i'],
            'price'                   => ['nullable', 'numeric', 'min:0'],
            'pitch_type'              => ['required', 'in:f5,f7,f8,f9,f11'],
            'players_count'           => ['required', 'integer', 'min:2'],
            'open_slots'              => ['nullable', 'integer', 'min:1'],
            'venue_name'              => ['required', 'string', 'max:255'],
            'neighborhood'            => ['nullable', 'string', 'max:100'],
            'address'                 => ['required', 'string', 'max:255'],
            'lat'                     => ['nullable', 'numeric', 'between:-90,90'],
            'lng'                     => ['nullable', 'numeric', 'between:-180,180'],
            'football_level'          => ['required', 'integer', 'between:1,10'],
            'gender'                  => ['required', 'in:masculino,femenino,mixto'],
            'field_surface'           => ['nullable', 'in:cemento,caucho,sintetico'],
            'establishment_covered'   => ['nullable', 'in:techado,descubierto'],
            'establishment_amenities' => ['nullable', 'array'],
            'establishment_amenities.*' => ['string', 'in:buffet,vestuario,parrilla'],
            'description'             => ['nullable', 'string'],
        ];
    }
}
