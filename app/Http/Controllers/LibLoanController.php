<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLibLoanRequest;
use App\Http\Requests\UpdateLibLoanRequest;
use App\Http\Resources\LibLoanResource;
use App\Models\LibLoan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LibLoanController extends Controller
{
    public function index(Request $request)
    {
        $query = LibLoan::query()->with([
            'libMember.student',
            'libBook',
        ]);

        $query->when($request->filled('student_id'), function ($q) use ($request) {
            $q->where('student_id', $request->query('student_id'));
        });

        $query->when($request->filled('book_id'), function ($q) use ($request) {
            $q->where('book_id', $request->query('book_id'));
        });

        $query->when($request->filled('loan_date'), function ($q) use ($request) {
            $q->whereDate('loan_date', $request->query('loan_date'));
        });

        $query->when($request->filled('search'), function ($q) use ($request) {
            $term = $request->query('search');

            $q->where(function ($inner) use ($term) {
                $inner->whereHas('libBook', function ($book) use ($term) {
                    $book->where('book_name', 'like', "%{$term}%")
                        ->orWhere('author', 'like', "%{$term}%")
                        ->orWhere('isbn', 'like', "%{$term}%");
                })->orWhereHas('libMember.student', function ($student) use ($term) {
                    $student->where('firstname', 'like', "%{$term}%")
                        ->orWhere('fathername', 'like', "%{$term}%");
                });
            });
        });

        $sortable = [
            'loan_id',
            'student_id',
            'book_id',
            'loan_date',
            'return_date',
        ];

        $sort = $request->query('sort', 'loan_id');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'loan_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return LibLoanResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreLibLoanRequest $request)
    {
        $loan = LibLoan::create($request->validated());

        return (new LibLoanResource(
            $loan->load(['libMember.student', 'libBook'])
        ))->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $loan = LibLoan::with([
            'libMember.student',
            'libBook',
        ])->findOrFail($id);

        return new LibLoanResource($loan);
    }

    public function update(UpdateLibLoanRequest $request, string $id)
    {
        $loan = LibLoan::findOrFail($id);
        $loan->update($request->validated());

        return new LibLoanResource(
            $loan->fresh()->load(['libMember.student', 'libBook'])
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $loan = LibLoan::findOrFail($id);
        $loan->delete();

        return response()->noContent();
    }
}