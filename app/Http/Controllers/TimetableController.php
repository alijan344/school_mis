<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Http\Resources\TimetableResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $query = Timetable::query()->with([
            'teacher',
            'subject',
            'classSection',
        ]);

        foreach (['weekday', 'lesson_hour', 'teacher_id', 'subject_id', 'section_id'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->query($field));
            }
        }

        $query->when($request->query('search'), function ($q, $term) {
            $q->where(function ($inner) use ($term) {
                $inner->whereHas('teacher', function ($teacher) use ($term) {
                    $teacher->where('firstname', 'like', "%{$term}%")
                        ->orWhere('lastname', 'like', "%{$term}%");
                })->orWhereHas('subject', function ($subject) use ($term) {
                    $subject->where('subject_name', 'like', "%{$term}%");
                })->orWhereHas('classSection', function ($section) use ($term) {
                    $section->where('section_name', 'like', "%{$term}%");
                });
            });
        });

        $sortable = [
            'weekday',
            'lesson_hour',
            'teacher_id',
            'subject_id',
            'section_id',
        ];

        $sort = $request->query('sort', 'weekday');
        $direction = $request->query('direction', 'asc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'weekday';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $query->orderBy($sort, $direction)
            ->orderBy('lesson_hour')
            ->orderBy('teacher_id');

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return TimetableResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'weekday' => ['required', 'integer', 'min:0', 'max:255'],
            'lesson_hour' => ['required', 'integer', 'min:0', 'max:255'],
            'teacher_id' => ['required', 'integer', 'exists:teacher,teacher_id'],
            'subject_id' => ['required', 'integer', 'exists:subject,subject_id'],
            'section_id' => ['required', 'integer', 'exists:class_section,section_id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        $exists = Timetable::where('weekday', $data['weekday'])
            ->where('lesson_hour', $data['lesson_hour'])
            ->where('teacher_id', $data['teacher_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'This timetable slot is already registered.',
                'errors' => new \stdClass(),
            ], 409);
        }

        $timetable = Timetable::create($data);

        return (new TimetableResource(
            $timetable->load(['teacher', 'subject', 'classSection'])
        ))->response()->setStatusCode(201);
    }

    public function show(
        int $weekday,
        int $lessonHour,
        int $teacherId
    ) {
        $timetable = Timetable::with([
            'teacher',
            'subject',
            'classSection',
        ])
            ->where('weekday', $weekday)
            ->where('lesson_hour', $lessonHour)
            ->where('teacher_id', $teacherId)
            ->firstOrFail();

        return new TimetableResource($timetable);
    }

    public function update(
        Request $request,
        int $weekday,
        int $lessonHour,
        int $teacherId
    ) {
        $timetable = Timetable::where('weekday', $weekday)
            ->where('lesson_hour', $lessonHour)
            ->where('teacher_id', $teacherId)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'subject_id' => ['sometimes', 'required', 'integer', 'exists:subject,subject_id'],
            'section_id' => ['sometimes', 'required', 'integer', 'exists:class_section,section_id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $timetable->update($validator->validated());

        return new TimetableResource(
            $timetable->load(['teacher', 'subject', 'classSection'])
        );
    }

    public function destroy(
        int $weekday,
        int $lessonHour,
        int $teacherId
    ): JsonResponse {
        $timetable = Timetable::where('weekday', $weekday)
            ->where('lesson_hour', $lessonHour)
            ->where('teacher_id', $teacherId)
            ->firstOrFail();

        $timetable->delete();

        return response()->noContent();
    }
}