<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query()->with([
            'classSection',
            'relatives',
            'transfers',
            'documents',
            'attendances',
        ]);

        foreach (['section_id', 'status', 'gender', 'birth_year'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->query($field));
            }
        }

        $query->when($request->query('search'), function ($q, $term) {
            $q->where(function ($inner) use ($term) {
                $inner->where('firstname', 'like', "%{$term}%")
                    ->orWhere('fathername', 'like', "%{$term}%")
                    ->orWhere('grandfathername', 'like', "%{$term}%")
                    ->orWhere('reg_no', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%");
            });
        });

        $sortable = [
            'student_id',
            'reg_no',
            'firstname',
            'birth_year',
            'gender',
            'status',
        ];

        $sort = $request->query('sort', 'student_id');
        $direction = $request->query('direction', 'asc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'student_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return StudentResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->validated());

        return (new StudentResource(
            $student->load('classSection')
        ))->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $student = Student::with([
            'classSection',
            'relatives',
            'transfers',
            'documents',
            'attendances',
        ])->findOrFail($id);

        return new StudentResource($student);
    }

    public function update(UpdateStudentRequest $request, string $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->validated());

        return new StudentResource(
            $student->fresh()->load('classSection')
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $student = Student::findOrFail($id);

        if (
            $student->relatives()->exists() ||
            $student->transfers()->exists() ||
            $student->documents()->exists() ||
            $student->attendances()->exists()
        ) {
            return response()->json([
                'message' => 'Student cannot be deleted because related records exist.',
                'errors' => new \stdClass(),
            ], 409);
        }

        $student->delete();

        return response()->noContent();
    }
}