<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherSalaryRequest;
use App\Http\Requests\UpdateTeacherSalaryRequest;
use App\Http\Resources\TeacherSalaryResource;
use App\Models\TeacherSalary;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TeacherSalaryController extends Controller
{
    public function index(Request $request)
    {
        $query = TeacherSalary::query()->with('teacher');

        foreach (['teacher_id', 'salary_year', 'salary_month'] as $field) {
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
            'salary_year',
            'salary_month',
            'tax_amount',
            'absent_amount',
            'loan_amount',
            'non_absent_bonus',
            'bonus',
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
            ->orderBy('teacher_id');

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return TeacherSalaryResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreTeacherSalaryRequest $request)
    {
        $data = $request->validated();

        $exists = TeacherSalary::where('teacher_id', $data['teacher_id'])
            ->where('salary_year', $data['salary_year'])
            ->where('salary_month', $data['salary_month'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Salary record already exists for this teacher and month.',
                'errors' => new \stdClass(),
            ], 409);
        }

        $salary = TeacherSalary::create($data);

        return (new TeacherSalaryResource(
            $salary->load('teacher')
        ))->response()->setStatusCode(201);
    }

    public function show(
        string $teacherId,
        string $year,
        string $month
    ) {
        return new TeacherSalaryResource(
            $this->findSalary($teacherId, $year, $month)->load('teacher')
        );
    }

    public function update(
        UpdateTeacherSalaryRequest $request,
        string $teacherId,
        string $year,
        string $month
    ) {
        $salary = $this->findSalary($teacherId, $year, $month);
        $salary->update($request->validated());

        return new TeacherSalaryResource(
            $salary->fresh()->load('teacher')
        );
    }

    public function destroy(
        string $teacherId,
        string $year,
        string $month
    ): JsonResponse {
        $salary = $this->findSalary($teacherId, $year, $month);
        $salary->delete();

        return response()->noContent();
    }

    private function findSalary(
        string $teacherId,
        string $year,
        string $month
    ): TeacherSalary {
        return TeacherSalary::where('teacher_id', $teacherId)
            ->where('salary_year', $year)
            ->where('salary_month', $month)
            ->firstOrFail();
    }
}