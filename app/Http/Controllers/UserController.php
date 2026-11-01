<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->with(['staff', 'userLevel']);

        $query->when($request->filled('staff_id'), function ($q) use ($request) {
            $q->where('staff_id', $request->query('staff_id'));
        });

        $query->when($request->query('search'), function ($q, $term) {
            $q->where(function ($inner) use ($term) {
                $inner->where('username', 'like', "%{$term}%")
                    ->orWhereHas('staff', function ($staff) use ($term) {
                        $staff->where('firstname', 'like', "%{$term}%")
                            ->orWhere('lastname', 'like', "%{$term}%");
                    });
            });
        });

        $sortable = ['staff_id', 'username'];
        $sort = $request->query('sort', 'staff_id');
        $direction = $request->query('direction', 'asc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'staff_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return UserResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        return (new UserResource(
            $user->load(['staff', 'userLevel'])
        ))->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $user = User::with(['staff', 'userLevel'])
            ->findOrFail($id);

        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());

        return new UserResource(
            $user->fresh()->load(['staff', 'userLevel'])
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->noContent();
    }
}