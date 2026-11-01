<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStaffSalaryRequest;
use App\Http\Requests\UpdateStaffSalaryRequest;
use App\Http\Resources\StaffSalaryResource;
use App\Models\StaffSalary;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StaffSalaryController extends Controller
{
    public function index(Request $request)
    {
        $query = StaffSalary::query()->with('staff');

        foreach (['staff_id', 'salary_year', 'salary_month'] as $field) {
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
            'salary_year',
            'salary_month',
            'absent_amount',
            'bonus',
            'tax_amount',
            'payable_salary',
            'net_salary',
            'pay_date',
        ];

        $sort = $request->query('sort', 'salary_year');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'salary_year';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction)
            ->orderBy('salary_month', 'desc')
            ->orderBy('staff_id');

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return StaffSalaryResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreStaffSalaryRequest $request)
    {
        $data = $request->validated();

        $exists = StaffSalary::where('staff_id', $data['staff_id'])
            ->where('salary_year', $data['salary_year'])
            ->where('salary_month', $data['salary_month'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Salary record already exists for this staff member and month.',
                'errors' => new \stdClass(),
            ], 409);
        }

        $salary = StaffSalary::create($data);

        return (new StaffSalaryResource(
            $salary->load('staff')
        ))->response()->setStatusCode(201);
    }

    public function show(string $staffId, string $year, string $month)
    {
        return new StaffSalaryResource(
            $this->findSalary($staffId, $year, $month)->load('staff')
        );
    }

    public function update(
        UpdateStaffSalaryRequest $request,
        string $staffId,
        string $year,
        string $month
    ) {
        $salary = $this->findSalary($staffId, $year, $month);
        $salary->update($request->validated());

        return new StaffSalaryResource(
            $salary->fresh()->load('staff')
        );
    }

    public function destroy(
        string $staffId,
        string $year,
        string $month
    ): JsonResponse {
        $salary = $this->findSalary($staffId, $year, $month);
        $salary->delete();

        return response()->noContent();
    }

    private function findSalary(
        string $staffId,
        string $year,
        string $month
    ): StaffSalary {
        return StaffSalary::where('staff_id', $staffId)
            ->where('salary_year', $year)
            ->where('salary_month', $month)
            ->firstOrFail();
    }
}