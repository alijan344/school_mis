<?php

namespace App\Http\Controllers;

use App\Models\Chartofaccount;
use App\Http\Requests\StoreChartofaccountRequest;
use App\Http\Requests\UpdateChartofaccountRequest;
use App\Http\Resources\ChartofaccountResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChartofaccountController extends Controller
{
    public function index(Request $request)
    {
        $query = Chartofaccount::query()->with('expenses');

        $query->when($request->query('search'), function ($q, $term) {
            $q->where('account_name', 'like', "%{$term}%");
        });

        $sortable = ['account_id', 'account_name'];
        $sort = $request->query('sort', 'account_id');
        $direction = $request->query('direction', 'asc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'account_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return ChartofaccountResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreChartofaccountRequest $request)
    {
        $account = Chartofaccount::create($request->validated());

        return (new ChartofaccountResource($account))
            ->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $account = Chartofaccount::with('expenses')->findOrFail($id);

        return new ChartofaccountResource($account);
    }

    public function update(UpdateChartofaccountRequest $request, string $id)
    {
        $account = Chartofaccount::findOrFail($id);
        $account->update($request->validated());

        return new ChartofaccountResource($account->fresh());
    }

    public function destroy(string $id): JsonResponse
    {
        $account = Chartofaccount::findOrFail($id);

        if ($account->expenses()->exists()) {
            return response()->json([
                'message' => 'This account cannot be deleted because it has related expenses.',
            ], 409);
        }

        $account->delete();

        return response()->noContent();
    }
}