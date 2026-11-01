<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherAttendanceRequest;
use App\Http\Requests\UpdateTeacherAttendanceRequest;
use App\Http\Resources\TeacherAttendanceResource;
use App\Models\TeacherAttendance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TeacherAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = TeacherAttendance::query()->with('teacher');

        foreach (
            ['teacher_id', 'absent_year', 'absent_month', 'absent_day']
            as $field
        ) {
            if ($request->filled($field)) {
                $query->where($field, $request->query($field));
            }
        }

        $query->when($request->query('search'), function ($q, $term) {
            $q->whereHas('teacher', function ($teacher) use ($term) {
                $teacher->where('firstname', 'like', "%{$term}%")
                    ->orWhere('lastname', 'like', "%{$term}%");
            });
        });

        $sortable = [
            'teacher_id',
            'absent_year',
            'absent_month',
            'absent_day',
        ];

        $sort = $request->query('sort', 'absent_year');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'absent_year';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction)
            ->orderBy('absent_month', 'desc')
            ->orderBy('absent_day', 'desc')
            ->orderBy('teacher_id');

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return TeacherAttendanceResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreTeacherAttendanceRequest $request)
    {
        $data = $request->validated();

        $exists = TeacherAttendance::where('teacher_id', $data['teacher_id'])
            ->where('absent_year', $data['absent_year'])
            ->where('absent_month', $data['absent_month'])
            ->where('absent_day', $data['absent_day'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Attendance already exists for this teacher and date.',
                'errors' => new \stdClass(),
            ], 409);
        }

        $attendance = TeacherAttendance::create($data);

        return (new TeacherAttendanceResource(
            $attendance->load('teacher')
        ))->response()->setStatusCode(201);
    }

    public function show(
        string $teacherId,
        string $year,
        string $month,
        string $day
    ) {
        $attendance = $this->findAttendance(
            $teacherId, $year, $month, $day
        );

        return new TeacherAttendanceResource(
            $attendance->load('teacher')
        );
    }

    public function update(
        UpdateTeacherAttendanceRequest $request,
        string $teacherId,
        string $year,
        string $month,
        string $day
    ) {
        $attendance = $this->findAttendance(
            $teacherId, $year, $month, $day
        );

        $attendance->update($request->validated());

        return new TeacherAttendanceResource(
            $attendance->fresh()->load('teacher')
        );
    }

    public function destroy(
        string $teacherId,
        string $year,
        string $month,
        string $day
    ): JsonResponse {
        $attendance = $this->findAttendance(
            $teacherId, $year, $month, $day
        );

        $attendance->delete();

        return response()->noContent();
    }

    private function findAttendance(
        string $teacherId,
        string $year,
        string $month,
        string $day
    ): TeacherAttendance {
        return TeacherAttendance::where('teacher_id', $teacherId)
            ->where('absent_year', $year)
            ->where('absent_month', $month)
            ->where('absent_day', $day)
            ->firstOrFail();
    }
}