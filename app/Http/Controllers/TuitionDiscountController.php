<?php

namespace App\Http\Controllers;

use App\Models\TuitionDiscount;
use App\Http\Resources\TuitionDiscountResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TuitionDiscountController extends Controller
{
    public function index(Request $request)
    {
        $query = TuitionDiscount::query()->with([
            'student',
            'classSection',
        ]);

        foreach (['student_id', 'discount_year', 'section_id', 'discount_type'] as $field) {
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

        $sortable = [
            'student_id',
            'discount_year',
            'section_id',
            'discount_amount',
            'discount_type',
        ];

        $sort = $request->query('sort', 'discount_year');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'discount_year';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction)
            ->orderBy('student_id');

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return TuitionDiscountResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => ['required', 'integer', 'exists:student,student_id'],
            'discount_year' => ['required', 'integer', 'min:1900', 'max:2200'],
            'section_id' => ['required', 'integer', 'exists:class_section,section_id'],
            'discount_amount' => ['required', 'numeric', 'min:0'],
            'discount_type' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        $exists = TuitionDiscount::where('student_id', $data['student_id'])
            ->where('discount_year', $data['discount_year'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'A tuition discount already exists for this student and year.',
                'errors' => new \stdClass(),
            ], 409);
        }

        $discount = TuitionDiscount::create($data);

        return (new TuitionDiscountResource(
            $discount->load(['student', 'classSection'])
        ))->response()->setStatusCode(201);
    }

    public function show(int $studentId, int $discountYear)
    {
        $discount = TuitionDiscount::with([
            'student',
            'classSection',
        ])
            ->where('student_id', $studentId)
            ->where('discount_year', $discountYear)
            ->firstOrFail();

        return new TuitionDiscountResource($discount);
    }

    public function update(
        Request $request,
        int $studentId,
        int $discountYear
    ) {
        $discount = TuitionDiscount::where('student_id', $studentId)
            ->where('discount_year', $discountYear)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'section_id' => ['sometimes', 'required', 'integer', 'exists:class_section,section_id'],
            'discount_amount' => ['sometimes', 'required', 'numeric', 'min:0'],
            'discount_type' => ['sometimes', 'required', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $discount->update($validator->validated());

        return new TuitionDiscountResource(
            $discount->load(['student', 'classSection'])
        );
    }

    public function destroy(
        int $studentId,
        int $discountYear
    ): JsonResponse {
        $discount = TuitionDiscount::where('student_id', $studentId)
            ->where('discount_year', $discountYear)
            ->firstOrFail();

        $discount->delete();

        return response()->noContent();
    }
}