<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Http\Resources\SubjectResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::query()->with(['timetables', 'scores']);

        $query->when($request->query('search'), function ($q, $term) {
            $q->where('subject_name', 'like', "%{$term}%");
        });

        $sortable = ['subject_id', 'subject_name'];
        $sort = $request->query('sort', 'subject_id');
        $direction = $request->query('direction', 'asc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'subject_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return SubjectResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreSubjectRequest $request)
    {
        $subject = Subject::create($request->validated());

        return (new SubjectResource($subject))
            ->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $subject = Subject::with(['timetables', 'scores'])
            ->findOrFail($id);

        return new SubjectResource($subject);
    }

    public function update(UpdateSubjectRequest $request, string $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->update($request->validated());

        return new SubjectResource(
            $subject->fresh()->load(['timetables', 'scores'])
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $subject = Subject::findOrFail($id);

        if (
            $subject->timetables()->exists() ||
            $subject->scores()->exists()
        ) {
            return response()->json([
                'message' => 'This subject cannot be deleted because it has related records.',
                'errors' => new \stdClass(),
            ], 409);
        }

        $subject->delete();

        return response()->noContent();
    }
}