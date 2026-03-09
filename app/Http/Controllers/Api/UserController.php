<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTOs\User\UserRegisterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterUserRequest;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $users,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = (int) $request->query('per_page', 100);
            $result = $this->users->list($perPage);

            return response()->json($result);
        } catch (Throwable) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->users->findById($id);

            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (Throwable) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            $dto = UserRegisterDTO::fromArray($request->validated());
            $user = $this->users->register($dto);

            return response()->json($user, 201);
        } catch (Throwable) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }
}
