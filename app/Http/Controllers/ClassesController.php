<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Http\Requests\StoreClassesRequest;
use App\Http\Requests\UpdateClassesRequest;
use App\Http\Resources\ClassResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    public function index(Request $request)
    {
        $query = Classes::query()->with('sections');

        // Filtering
        $query->when($request->filled('fees'), function ($q) use ($request) {
            $q->where('fees', $request->query('fees'));
        });

        // Searching
        $query->when($request->query('search'), function ($q, $term) {
            $q->where('class_name', 'like', "%{$term}%");
        });

        // Sorting with whitelist
        $sortable = ['class_id', 'class_name', 'fees'];

        $sort = $request->query('sort', 'class_id');
        $direction = $request->query('direction', 'asc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'class_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $query->orderBy($sort, $direction);

        // Pagination with maximum 100
        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return ClassResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreClassesRequest $request)
    {
        $class = Classes::create($request->validated());

        return (new ClassResource($class->load('sections')))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Classes $class)
    {
        return new ClassResource($class->load('sections'));
    }

    public function update(
        UpdateClassesRequest $request,
        Classes $class
    ) {
        $class->update($request->validated());

        return new ClassResource(
            $class->fresh()->load('sections')
        );
    }

    public function destroy(Classes $class): JsonResponse
    {
        if ($class->sections()->exists()) {
            return response()->json([
                'message' => 'This class cannot be deleted because it has sections.',
            ], 409);
        }

        $class->delete();

        return response()->noContent();
    }
}