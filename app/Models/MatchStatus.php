<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchStatus extends Model
{
    use HasFactory;

    protected $table = 'match_statuses';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function matches()
    {
        return $this->hasMany(GameMatch::class, 'status_id');
    }
}
