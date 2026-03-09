<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GameMatch extends Model
{
    use HasFactory;

    protected $table = 'matches';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'time',
        'price',
        'pitch_type',
        'players_count',
        'open_slots',
        'venue_name',
        'neighborhood',
        'address',
        'lat',
        'lng',
        'football_level',
        'gender',
        'field_surface',
        'establishment_covered',
        'establishment_amenities',
        'description',
        'status_id',
        'created_by',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'date'                    => 'date',
        'price'                   => 'decimal:2',
        'players_count'           => 'integer',
        'open_slots'              => 'integer',
        'football_level'          => 'integer',
        'lat'                     => 'float',
        'lng'                     => 'float',
        'establishment_amenities' => 'array',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(MatchStatus::class, 'status_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'match_players', 'match_id', 'user_id')
            ->withPivot('joined_at');
    }
}
