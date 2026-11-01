<?php

namespace App\Http\Controllers;

use App\Models\StudentTransfer;
use App\Http\Requests\StoreStudentTransferRequest;
use App\Http\Requests\UpdateStudentTransferRequest;
use App\Http\Resources\StudentTransferResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentTransferController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentTransfer::query()->with('student');

        foreach (['student_id', 'transfer_type', 'transfer_date'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->query($field));
            }
        }

        $query->when($request->query('search'), function ($q, $term) {
            $q->where(function ($inner) use ($term) {
                $inner->where('school_name', 'like', "%{$term}%")
                    ->orWhere('transfer_no', 'like', "%{$term}%");
            });
        });

        $sortable = [
            'transfer_id',
            'student_id',
            'transfer_date',
            'transfer_no',
            'school_name',
            'transfer_type',
        ];

        $sort = $request->query('sort', 'transfer_id');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'transfer_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return StudentTransferResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreStudentTransferRequest $request)
    {
        $transfer = StudentTransfer::create($request->validated());

        return (new StudentTransferResource(
            $transfer->load('student')
        ))->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $transfer = StudentTransfer::with('student')->findOrFail($id);

        return new StudentTransferResource($transfer);
    }

    public function update(
        UpdateStudentTransferRequest $request,
        string $id
    ) {
        $transfer = StudentTransfer::findOrFail($id);
        $transfer->update($request->validated());

        return new StudentTransferResource(
            $transfer->fresh()->load('student')
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $transfer = StudentTransfer::findOrFail($id);
        $transfer->delete();

        return response()->noContent();
    }
}