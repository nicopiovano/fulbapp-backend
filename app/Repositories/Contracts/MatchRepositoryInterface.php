<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\GameMatch;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MatchRepositoryInterface
{
    public function create(array $data): GameMatch;

    public function update(GameMatch $match, array $data): GameMatch;

    public function find(int $id): ?GameMatch;

    /**
     * @return LengthAwarePaginator<GameMatch>
     */
    public function paginate(int $perPage = 15, ?int $currentUserId = null): LengthAwarePaginator;
}
