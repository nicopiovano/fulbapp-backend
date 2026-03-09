<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\User\UserRegisterDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
    ) {
    }

    public function register(UserRegisterDTO $dto): User
    {
        $data = $dto->toArray();
        $data['password'] = Hash::make($data['password']);

        return $this->users->create($data);
    }

    public function list(int $perPage = 100): LengthAwarePaginator
    {
        return $this->users->paginate($perPage);
    }

    public function findById(int $id): User
    {
        $user = $this->users->find($id);

        if (! $user) {
            throw new ModelNotFoundException('Usuario no encontrado');
        }

        return $user;
    }
}
