<?php

namespace App\Http\Controllers;

use App\Models\StudentRelative;
use App\Http\Requests\StoreStudentRelativeRequest;
use App\Http\Requests\UpdateStudentRelativeRequest;
use App\Http\Resources\StudentRelativeResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentRelativeController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentRelative::query()->with('student');

        foreach (['student_id', 'relative_relation'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->query($field));
            }
        }

        $query->when($request->query('search'), function ($q, $term) {
            $q->where(function ($inner) use ($term) {
                $inner->where('relative_name', 'like', "%{$term}%")
                    ->orWhere('relative_phone', 'like', "%{$term}%");
            });
        });

        $sortable = [
            'relative_id',
            'student_id',
            'relative_name',
            'relative_relation',
        ];

        $sort = $request->query('sort', 'relative_id');
        $direction = $request->query('direction', 'asc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'relative_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return StudentRelativeResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreStudentRelativeRequest $request)
    {
        $relative = StudentRelative::create($request->validated());

        return (new StudentRelativeResource(
            $relative->load('student')
        ))->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $relative = StudentRelative::with('student')->findOrFail($id);

        return new StudentRelativeResource($relative);
    }

    public function update(
        UpdateStudentRelativeRequest $request,
        string $id
    ) {
        $relative = StudentRelative::findOrFail($id);
        $relative->update($request->validated());

        return new StudentRelativeResource(
            $relative->fresh()->load('student')
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $relative = StudentRelative::findOrFail($id);
        $relative->delete();

        return response()->noContent();
    }
}