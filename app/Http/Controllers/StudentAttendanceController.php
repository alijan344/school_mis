<?php

namespace App\Http\Controllers;

use App\Models\StudentAttendance;
use App\Http\Requests\StoreStudentAttendanceRequest;
use App\Http\Requests\UpdateStudentAttendanceRequest;
use App\Http\Resources\StudentAttendanceResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentAttendance::query()->with('student');

        foreach (['student_id', 'absent_date', 'absent_type'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->query($field));
            }
        }

        $query->when($request->query('search'), function ($q, $term) {
            $q->whereHas('student', function ($student) use ($term) {
                $student->where('firstname', 'like', "%{$term}%")
                    ->orWhere('fathername', 'like', "%{$term}%");
            });
        });

        $sortable = ['student_id', 'absent_date', 'absent_type'];
        $sort = $request->query('sort', 'absent_date');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'absent_date';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction)
            ->orderBy('student_id');

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return StudentAttendanceResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreStudentAttendanceRequest $request)
    {
        $data = $request->validated();

        $exists = StudentAttendance::where('student_id', $data['student_id'])
            ->where('absent_date', $data['absent_date'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Attendance for this student and date already exists.',
                'errors' => new \stdClass(),
            ], 409);
        }

        $attendance = StudentAttendance::create($data);

        return (new StudentAttendanceResource(
            $attendance->load('student')
        ))->response()->setStatusCode(201);
    }

    public function show(string $studentId, string $absentDate)
    {
        $attendance = StudentAttendance::with('student')
            ->where('student_id', $studentId)
            ->where('absent_date', $absentDate)
            ->firstOrFail();

        return new StudentAttendanceResource($attendance);
    }

    public function update(
        UpdateStudentAttendanceRequest $request,
        string $studentId,
        string $absentDate
    ) {
        $attendance = StudentAttendance::where('student_id', $studentId)
            ->where('absent_date', $absentDate)
            ->firstOrFail();

        $attendance->update($request->validated());

        return new StudentAttendanceResource(
            $attendance->fresh()->load('student')
        );
    }

    public function destroy(
        string $studentId,
        string $absentDate
    ): JsonResponse {
        $attendance = StudentAttendance::where('student_id', $studentId)
            ->where('absent_date', $absentDate)
            ->firstOrFail();

        $attendance->delete();

        return response()->noContent();
    }
}