<?php

namespace App\Http\Controllers;

use App\Models\UserLevel;
use App\Http\Requests\StoreUserLevelRequest;
use App\Http\Requests\UpdateUserLevelRequest;
use App\Http\Resources\UserLevelResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserLevelController extends Controller
{
    public function index(Request $request)
    {
        $query = UserLevel::query()->with('user');

        $permissions = [
            'admin_level',
            'academic_level',
            'student_level',
            'teacher_level',
            'staff_level',
            'finance_level',
            'library_level',
            'stock_level',
            'IT_level',
        ];

        foreach ($permissions as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->query($field));
            }
        }

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->query('staff_id'));
        }

        $sortable = array_merge(['staff_id'], $permissions);
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

        return UserLevelResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreUserLevelRequest $request)
    {
        $level = UserLevel::create($request->validated());

        return (new UserLevelResource(
            $level->load('user')
        ))->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $level = UserLevel::with('user')->findOrFail($id);

        return new UserLevelResource($level);
    }

    public function update(
        UpdateUserLevelRequest $request,
        string $id
    ) {
        $level = UserLevel::findOrFail($id);
        $level->update($request->validated());

        return new UserLevelResource(
            $level->fresh()->load('user')
        );
    }

    public function destroy(string $id): JsonResponse
    {
        UserLevel::findOrFail($id)->delete();

        return response()->noContent();
    }
}