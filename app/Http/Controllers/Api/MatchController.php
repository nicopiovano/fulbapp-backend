<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTOs\Match\CreateMatchDTO;
use App\DTOs\Match\UpdateMatchDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Match\StoreMatchRequest;
use App\Http\Requests\Match\UpdateMatchRequest;
use App\Http\Resources\MatchResource;
use App\Services\MatchService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Throwable;

class MatchController extends Controller
{
    public function __construct(
        private readonly MatchService $service,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = (int) $request->query('per_page', 50);
            $currentUserId = (int) $request->user()->id;
            $matches = $this->service->list($perPage, $currentUserId);

            return response()->json(MatchResource::collection($matches));
        } catch (Throwable) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $match = $this->service->get($id);

            return response()->json(new MatchResource($match));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (Throwable) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function store(StoreMatchRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $userId = (int) $request->user()->id;
            $statusId = $this->service->getDefaultOpenStatusId();

            $dto = CreateMatchDTO::fromArray($validated, $userId, $statusId);
            $match = $this->service->create($dto);

            return response()->json(new MatchResource($match), 201);
        } catch (Throwable) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function update(UpdateMatchRequest $request, int $id): JsonResponse
    {
        try {
            $dto = UpdateMatchDTO::fromArray($id, $request->validated());
            $match = $this->service->update($dto);

            return response()->json(new MatchResource($match));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (Throwable) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function join(Request $request, int $id): JsonResponse
    {
        try {
            $userId = (int) $request->user()->id;
            $match = $this->service->joinMatch($id, $userId);

            return response()->json(new MatchResource($match));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (Throwable) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function leave(Request $request, int $id): JsonResponse
    {
        try {
            $userId = (int) $request->user()->id;
            $match = $this->service->leaveMatch($id, $userId);

            return response()->json(new MatchResource($match));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (Throwable) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function cancel(Request $request, int $id): JsonResponse
    {
        try {
            $userId = (int) $request->user()->id;
            $match = $this->service->cancelMatch($id, $userId);

            return response()->json(new MatchResource($match));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 422);
        } catch (Throwable) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }
}
