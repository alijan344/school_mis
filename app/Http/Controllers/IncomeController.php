<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Http\Resources\IncomeResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Income::query();

        $query->when($request->filled('source_id'), function ($q) use ($request) {
            $q->where('source_id', $request->query('source_id'));
        });

        $query->when($request->filled('student_id'), function ($q) use ($request) {
            $q->where('student_id', $request->query('student_id'));
        });

        $query->when($request->filled('income_date'), function ($q) use ($request) {
            $q->whereDate('income_date', $request->query('income_date'));
        });

        $sortable = [
            'income_id',
            'source_id',
            'student_id',
            'income_amount',
            'income_date'
        ];

        $sort = $request->query('sort', 'income_id');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'income_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return IncomeResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreIncomeRequest $request)
    {
        $income = Income::create($request->validated());

        return (new IncomeResource($income))
            ->response()->setStatusCode(201);
    }

    public function show($id)
    {
        return new IncomeResource(Income::findOrFail($id));
    }

    public function update(UpdateIncomeRequest $request, $id)
    {
        $income = Income::findOrFail($id);
        $income->update($request->validated());

        return new IncomeResource($income->fresh());
    }

    public function destroy($id): JsonResponse
    {
        $income = Income::findOrFail($id);
        $income->delete();

        return response()->noContent();
    }
}