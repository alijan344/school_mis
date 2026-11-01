<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Http\Resources\ScoreResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Score::query()->with([
            'student',
            'subject',
            'classSection',
        ]);

        foreach (['student_id', 'subject_id', 'section_id', 'exam_year'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->query($field));
            }
        }

        $query->when($request->query('search'), function ($q, $term) {
            $q->where(function ($inner) use ($term) {
                $inner->whereHas('student', function ($student) use ($term) {
                    $student->where('firstname', 'like', "%{$term}%")
                        ->orWhere('fathername', 'like', "%{$term}%");
                })->orWhereHas('subject', function ($subject) use ($term) {
                    $subject->where('subject_name', 'like', "%{$term}%");
                });
            });
        });

        $sortable = [
            'student_id',
            'subject_id',
            'exam_year',
            'section_id',
            'mid_exam',
            'final_exam',
            'second_chance',
            'total_mark',
        ];

        $sort = $request->query('sort', 'exam_year');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'exam_year';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction)
            ->orderBy('student_id')
            ->orderBy('subject_id');

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return ScoreResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => ['required', 'integer', 'exists:student,student_id'],
            'subject_id' => ['required', 'integer', 'exists:subject,subject_id'],
            'exam_year' => ['required', 'integer', 'min:1900', 'max:2200'],
            'section_id' => ['required', 'integer', 'exists:class_section,section_id'],
            'mid_exam' => ['required', 'integer', 'min:0', 'max:255'],
            'final_exam' => ['nullable', 'integer', 'min:0', 'max:255'],
            'second_chance' => ['nullable', 'integer', 'min:0', 'max:255'],
            'total_mark' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        $exists = Score::where('student_id', $data['student_id'])
            ->where('subject_id', $data['subject_id'])
            ->where('exam_year', $data['exam_year'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'A score already exists for this student, subject and year.',
                'errors' => new \stdClass(),
            ], 409);
        }

        $score = Score::create($data);

        return (new ScoreResource(
            $score->load(['student', 'subject', 'classSection'])
        ))->response()->setStatusCode(201);
    }

    public function show(
        int $studentId,
        int $subjectId,
        int $examYear
    ) {
        $score = Score::with(['student', 'subject', 'classSection'])
            ->where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->where('exam_year', $examYear)
            ->firstOrFail();

        return new ScoreResource($score);
    }

    public function update(
        Request $request,
        int $studentId,
        int $subjectId,
        int $examYear
    ) {
        $score = Score::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->where('exam_year', $examYear)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'section_id' => ['sometimes', 'required', 'integer', 'exists:class_section,section_id'],
            'mid_exam' => ['sometimes', 'required', 'integer', 'min:0', 'max:255'],
            'final_exam' => ['sometimes', 'nullable', 'integer', 'min:0', 'max:255'],
            'second_chance' => ['sometimes', 'nullable', 'integer', 'min:0', 'max:255'],
            'total_mark' => ['sometimes', 'nullable', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $score->update($validator->validated());

        return new ScoreResource(
            $score->load(['student', 'subject', 'classSection'])
        );
    }

    public function destroy(
        int $studentId,
        int $subjectId,
        int $examYear
    ): JsonResponse {
        $score = Score::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->where('exam_year', $examYear)
            ->firstOrFail();

        $score->delete();

        return response()->noContent();
    }
}