<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $auth,
    ) {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            ['token' => $token, 'user' => $user] = $this->auth->login($data['email'], $data['password']);

            return response()->json([
                'token' => $token,
                'user'  => $user,
            ]);
        } catch (AuthenticationException $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        } catch (Throwable $th) {
            dd($th->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            /** @var \App\Models\User $user */
            $user = $request->user();
            $this->auth->logout($user);

            return response()->json(['message' => 'Logged out']);
        } catch (Throwable) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}
