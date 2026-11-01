<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::query()->with([
            'documents',
            'attendances',
            'salaries',
            'timetables',
        ]);

        foreach (['status', 'gender', 'birth_year'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->query($field));
            }
        }

        $query->when($request->query('search'), function ($q, $term) {
            $q->where(function ($inner) use ($term) {
                $inner->where('firstname', 'like', "%{$term}%")
                    ->orWhere('lastname', 'like', "%{$term}%")
                    ->orWhere('fathername', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('education_field', 'like', "%{$term}%");
            });
        });

        $sortable = [
            'teacher_id',
            'firstname',
            'lastname',
            'birth_year',
            'status',
            'gross_salary',
            'talent_score',
        ];

        $sort = $request->query('sort', 'teacher_id');
        $direction = $request->query('direction', 'asc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'teacher_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return TeacherResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreTeacherRequest $request)
    {
        $teacher = Teacher::create($request->validated());

        return (new TeacherResource(
            $teacher->load('documents')
        ))->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $teacher = Teacher::with([
            'documents',
            'attendances',
            'salaries',
            'timetables',
        ])->findOrFail($id);

        return new TeacherResource($teacher);
    }

    public function update(UpdateTeacherRequest $request, string $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->update($request->validated());

        return new TeacherResource(
            $teacher->fresh()->load([
                'documents',
                'attendances',
                'salaries',
                'timetables',
            ])
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $teacher = Teacher::findOrFail($id);

        if (
            $teacher->documents()->exists() ||
            $teacher->attendances()->exists() ||
            $teacher->salaries()->exists() ||
            $teacher->timetables()->exists()
        ) {
            return response()->json([
                'message' => 'This teacher cannot be deleted because related records exist.',
                'errors' => new \stdClass(),
            ], 409);
        }

        $teacher->delete();

        return response()->noContent();
    }
}