<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLibMemberRequest;
use App\Http\Requests\UpdateLibMemberRequest;
use App\Http\Resources\LibMemberResource;
use App\Models\LibMember;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LibMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = LibMember::query()->with([
            'student',
            'loans.libBook',
        ]);

        $query->when($request->filled('reg_date'), function ($q) use ($request) {
            $q->whereDate('reg_date', $request->query('reg_date'));
        });

        $query->when($request->filled('search'), function ($q) use ($request) {
            $term = $request->query('search');

            $q->whereHas('student', function ($student) use ($term) {
                $student->where('firstname', 'like', "%{$term}%")
                    ->orWhere('fathername', 'like', "%{$term}%")
                    ->orWhere('grandfathername', 'like', "%{$term}%");
            });
        });

        $sortable = ['student_id', 'reg_date'];
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

        return LibMemberResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreLibMemberRequest $request)
    {
        $member = LibMember::create($request->validated());

        return (new LibMemberResource(
            $member->load(['student', 'loans.libBook'])
        ))->response()->setStatusCode(201);
    }

    public function show(string $studentId)
    {
        $member = LibMember::with([
            'student',
            'loans.libBook',
        ])->findOrFail($studentId);

        return new LibMemberResource($member);
    }

    public function update(
        UpdateLibMemberRequest $request,
        string $studentId
    ) {
        $member = LibMember::findOrFail($studentId);
        $member->update($request->validated());

        return new LibMemberResource(
            $member->fresh()->load(['student', 'loans.libBook'])
        );
    }

    public function destroy(string $studentId): JsonResponse
    {
        $member = LibMember::findOrFail($studentId);

        if ($member->loans()->exists()) {
            return response()->json([
                'message' => 'This library member has loan records and cannot be deleted.',
                'errors' => new \stdClass(),
            ], 409);
        }

        $member->delete();

        return response()->noContent();
    }
}