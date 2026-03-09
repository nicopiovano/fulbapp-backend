<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        /** @var User $user */
        $user = User::query()->create($data);

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        /** @var User|null $user */
        $user = User::query()->where('email', $email)->first();

        return $user;
    }

    public function find(int $id): ?User
    {
        /** @var User|null $user */
        $user = User::query()->find($id);

        return $user;
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        /** @var LengthAwarePaginator $paginator */
        $paginator = User::query()->paginate($perPage);

        return $paginator;
    }
}

