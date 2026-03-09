<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\GameMatch;
use App\Repositories\Contracts\MatchRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MatchRepository implements MatchRepositoryInterface
{
    public function create(array $data): GameMatch
    {
        /** @var GameMatch $match */
        $match = GameMatch::query()->create($data);

        return $match->load(['status', 'creator', 'players']);
    }

    public function update(GameMatch $match, array $data): GameMatch
    {
        $match->fill($data);
        $match->save();

        return $match->load(['status', 'creator', 'players']);
    }

    public function find(int $id): ?GameMatch
    {
        /** @var GameMatch|null $match */
        $match = GameMatch::query()
            ->with(['status', 'creator', 'players'])
            ->find($id);

        return $match;
    }

    public function paginate(int $perPage = 15, ?int $currentUserId = null): LengthAwarePaginator
    {
        /** @var LengthAwarePaginator $paginator */
        $paginator = GameMatch::query()
            ->with(['status', 'creator', 'players'])
            ->where(function ($q) use ($currentUserId): void {
                // Partidos de hoy o futuros → siempre visibles
                $q->whereDate('date', '>=', now()->toDateString());

                // Partidos pasados/cancelados propios → también visibles
                if ($currentUserId !== null) {
                    $q->orWhere('created_by', $currentUserId);
                }
            })
            ->orderBy('date')
            ->paginate($perPage);

        return $paginator;
    }
}
