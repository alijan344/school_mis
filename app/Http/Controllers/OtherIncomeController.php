<?php

namespace App\Http\Controllers;

use App\Models\OtherIncome;
use App\Http\Requests\StoreOtherIncomeRequest;
use App\Http\Requests\UpdateOtherIncomeRequest;
use App\Http\Resources\OtherIncomeResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OtherIncomeController extends Controller
{
    public function index(Request $request)
    {
        $query = OtherIncome::query();

        $query->when($request->filled('source_id'), function ($q) use ($request) {
            $q->where('source_id', $request->query('source_id'));
        });

        $query->when($request->filled('income_date'), function ($q) use ($request) {
            $q->whereDate('income_date', $request->query('income_date'));
        });

        $sortable = [
            'income_id',
            'source_id',
            'income_amount',
            'income_date',
        ];

        $sort = $request->query('sort', 'income_id');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'income_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction)
            ->orderBy('source_id', 'asc');

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return OtherIncomeResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreOtherIncomeRequest $request)
    {
        $otherIncome = OtherIncome::create($request->validated());

        return (new OtherIncomeResource($otherIncome))
            ->response()->setStatusCode(201);
    }

    public function show($incomeId, $sourceId)
    {
        $otherIncome = OtherIncome::where('income_id', $incomeId)
            ->where('source_id', $sourceId)
            ->firstOrFail();

        return new OtherIncomeResource($otherIncome);
    }

    public function update(
        UpdateOtherIncomeRequest $request,
        $incomeId,
        $sourceId
    ) {
        $otherIncome = OtherIncome::where('income_id', $incomeId)
            ->where('source_id', $sourceId)
            ->firstOrFail();

        $otherIncome->update($request->validated());

        return new OtherIncomeResource($otherIncome->fresh());
    }

    public function destroy($incomeId, $sourceId): JsonResponse
    {
        $otherIncome = OtherIncome::where('income_id', $incomeId)
            ->where('source_id', $sourceId)
            ->firstOrFail();

        $otherIncome->delete();

        return response()->noContent();
    }
}