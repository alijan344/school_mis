<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStaffAttendanceRequest;
use App\Http\Requests\UpdateStaffAttendanceRequest;
use App\Http\Resources\StaffAttendanceResource;
use App\Models\StaffAttendance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StaffAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = StaffAttendance::query()->with('staff');

        foreach (
            ['staff_id', 'absent_year', 'absent_month', 'absent_day']
            as $field
        ) {
            if ($request->filled($field)) {
                $query->where($field, $request->query($field));
            }
        }

        $query->when($request->query('search'), function ($q, $term) {
            $q->whereHas('staff', function ($staff) use ($term) {
                $staff->where('firstname', 'like', "%{$term}%")
                    ->orWhere('lastname', 'like', "%{$term}%");
            });
        });

        $sortable = [
            'staff_id',
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
            ->orderBy('staff_id');

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return StaffAttendanceResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreStaffAttendanceRequest $request)
    {
        $data = $request->validated();

        $exists = StaffAttendance::where('staff_id', $data['staff_id'])
            ->where('absent_year', $data['absent_year'])
            ->where('absent_month', $data['absent_month'])
            ->where('absent_day', $data['absent_day'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Attendance already exists for this staff member and date.',
                'errors' => new \stdClass(),
            ], 409);
        }

        $attendance = StaffAttendance::create($data);

        return (new StaffAttendanceResource(
            $attendance->load('staff')
        ))->response()->setStatusCode(201);
    }

    public function show(
        string $staffId,
        string $year,
        string $month,
        string $day
    ) {
        $attendance = $this->findAttendance(
            $staffId, $year, $month, $day
        );

        return new StaffAttendanceResource(
            $attendance->load('staff')
        );
    }

    public function update(
        UpdateStaffAttendanceRequest $request,
        string $staffId,
        string $year,
        string $month,
        string $day
    ) {
        $attendance = $this->findAttendance(
            $staffId, $year, $month, $day
        );

        $attendance->update($request->validated());

        return new StaffAttendanceResource(
            $attendance->fresh()->load('staff')
        );
    }

    public function destroy(
        string $staffId,
        string $year,
        string $month,
        string $day
    ): JsonResponse {
        $attendance = $this->findAttendance(
            $staffId, $year, $month, $day
        );

        $attendance->delete();

        return response()->noContent();
    }

    private function findAttendance(
        string $staffId,
        string $year,
        string $month,
        string $day
    ): StaffAttendance {
        return StaffAttendance::where('staff_id', $staffId)
            ->where('absent_year', $year)
            ->where('absent_month', $month)
            ->where('absent_day', $day)
            ->firstOrFail();
    }
}