<?php

namespace App\Http\Controllers;

use App\Models\IncomeSource;
use App\Http\Requests\StoreIncomeSourceRequest;
use App\Http\Requests\UpdateIncomeSourceRequest;
use App\Http\Resources\IncomeSourceResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class IncomeSourceController extends Controller
{
    public function index(Request $request)
    {
        $query = IncomeSource::query()->with(['incomes', 'otherIncomes']);

        $query->when($request->query('search'), function ($q, $term) {
            $q->where('source_name', 'like', "%{$term}%");
        });

        $sortable = ['source_id', 'source_name'];
        $sort = $request->query('sort', 'source_id');
        $direction = $request->query('direction', 'asc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'source_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return IncomeSourceResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreIncomeSourceRequest $request)
    {
        $source = IncomeSource::create($request->validated());

        return (new IncomeSourceResource($source))
            ->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $source = IncomeSource::with(['incomes', 'otherIncomes'])
            ->findOrFail($id);

        return new IncomeSourceResource($source);
    }

    public function update(UpdateIncomeSourceRequest $request, string $id)
    {
        $source = IncomeSource::findOrFail($id);
        $source->update($request->validated());

        return new IncomeSourceResource($source->fresh());
    }

    public function destroy(string $id): JsonResponse
    {
        $source = IncomeSource::findOrFail($id);

        if (
            $source->incomes()->exists() ||
            $source->otherIncomes()->exists()
        ) {
            return response()->json([
                'message' => 'This income source cannot be deleted because it has related income records.',
            ], 409);
        }

        $source->delete();

        return response()->noContent();
    }
}