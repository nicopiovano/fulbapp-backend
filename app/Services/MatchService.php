<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Match\CreateMatchDTO;
use App\DTOs\Match\UpdateMatchDTO;
use App\Models\GameMatch;
use App\Models\MatchStatus;
use App\Repositories\Contracts\MatchRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;

class MatchService
{
    public function __construct(
        private readonly MatchRepositoryInterface $matches,
    ) {
    }

    public function list(int $perPage = 20, ?int $currentUserId = null): LengthAwarePaginator
    {
        return $this->matches->paginate($perPage, $currentUserId);
    }

    public function get(int $id): GameMatch
    {
        $match = $this->matches->find($id);

        if (! $match) {
            throw new ModelNotFoundException('Partido no encontrado');
        }

        return $match;
    }

    public function create(CreateMatchDTO $dto): GameMatch
    {
        return $this->matches->create($dto->toArray());
    }

    public function update(UpdateMatchDTO $dto): GameMatch
    {
        $match = $this->get($dto->id);

        return $this->matches->update($match, $dto->toArray());
    }

    public function joinMatch(int $matchId, int $userId): GameMatch
    {
        $match = $this->get($matchId);

        if ($match->players()->where('user_id', $userId)->exists()) {
            throw new InvalidArgumentException('Ya estás anotado en este partido');
        }

        $capacity = $match->open_slots ?? $match->players_count;

        if ($match->players()->count() >= $capacity) {
            throw new InvalidArgumentException('El partido está completo');
        }

        $match->players()->attach($userId, ['joined_at' => now()]);

        return $this->get($matchId);
    }

    public function leaveMatch(int $matchId, int $userId): GameMatch
    {
        $match = $this->get($matchId);
        $match->players()->detach($userId);

        return $this->get($matchId);
    }

    public function cancelMatch(int $matchId, int $userId): GameMatch
    {
        $match = $this->get($matchId);

        if ((int) $match->created_by !== $userId) {
            throw new \RuntimeException('Solo el organizador puede cancelar el partido', 403);
        }

        /** @var MatchStatus $status */
        $status = MatchStatus::query()->firstOrCreate(['name' => 'cancelled']);

        return $this->matches->update($match, ['status_id' => $status->id]);
    }

    public function getDefaultOpenStatusId(): int
    {
        /** @var MatchStatus|null $status */
        $status = MatchStatus::query()->where('name', 'open')->first();

        if (! $status) {
            $status = MatchStatus::query()->create(['name' => 'open']);
        }

        return (int) $status->id;
    }
}
