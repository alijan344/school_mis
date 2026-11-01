<?php

namespace App\Http\Controllers;

use App\Models\ClassSection;
use App\Http\Requests\StoreClassSectionRequest;
use App\Http\Requests\UpdateClassSectionRequest;
use App\Http\Resources\ClassSectionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClassSectionController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassSection::query()->with('schoolClass');

        // Filtering
        $query->when($request->filled('class_id'), function ($q) use ($request) {
            $q->where('class_id', $request->query('class_id'));
        });

        // Searching
        $query->when($request->query('search'), function ($q, $term) {
            $q->where('section_name', 'like', "%{$term}%");
        });

        // Sorting with whitelist
        $sortable = ['section_id', 'section_name', 'class_id'];

        $sort = $request->query('sort', 'section_id');
        $direction = $request->query('direction', 'asc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'section_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $query->orderBy($sort, $direction);

        // Pagination with maximum 100
        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return ClassSectionResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreClassSectionRequest $request)
    {
        $section = ClassSection::create($request->validated());

        return (new ClassSectionResource(
            $section->load('schoolClass')
        ))
            ->response()
            ->setStatusCode(201);
    }

    public function show(ClassSection $classSection)
    {
        return new ClassSectionResource(
            $classSection->load('schoolClass')
        );
    }

    public function update(
        UpdateClassSectionRequest $request,
        ClassSection $classSection
    ) {
        $classSection->update($request->validated());

        return new ClassSectionResource(
            $classSection->fresh()->load('schoolClass')
        );
    }

    public function destroy(ClassSection $classSection): JsonResponse
    {
        if (
            $classSection->students()->exists()
            || $classSection->timetables()->exists()
            || $classSection->scores()->exists()
        ) {
            return response()->json([
                'message' => 'This section cannot be deleted because it has related records.',
            ], 409);
        }

        $classSection->delete();

        return response()->noContent();
    }
}