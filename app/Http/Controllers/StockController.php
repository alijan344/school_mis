<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Http\Resources\StockResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Stock::query()->with(['stockIns', 'stockOuts']);

        $query->when($request->filled('unit'), function ($q) use ($request) {
            $q->where('unit', $request->query('unit'));
        });

        $query->when($request->query('search'), function ($q, $term) {
            $q->where(function ($inner) use ($term) {
                $inner->where('item_name', 'like', "%{$term}%")
                    ->orWhere('unit', 'like', "%{$term}%");
            });
        });

        $sortable = ['stock_id', 'item_name', 'unit', 'quantity'];

        $sort = $request->query('sort', 'stock_id');
        $direction = $request->query('direction', 'asc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'stock_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return StockResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreStockRequest $request)
    {
        $stock = Stock::create($request->validated());

        return (new StockResource(
            $stock->load(['stockIns', 'stockOuts'])
        ))->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $stock = Stock::with(['stockIns', 'stockOuts'])->findOrFail($id);

        return new StockResource($stock);
    }

    public function update(UpdateStockRequest $request, string $id)
    {
        $stock = Stock::findOrFail($id);
        $stock->update($request->validated());

        return new StockResource(
            $stock->fresh()->load(['stockIns', 'stockOuts'])
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $stock = Stock::findOrFail($id);

        if (
            $stock->stockIns()->exists() ||
            $stock->stockOuts()->exists()
        ) {
            return response()->json([
                'message' => 'This stock item cannot be deleted because it has stock in/out records.',
                'errors' => new \stdClass(),
            ], 409);
        }

        $stock->delete();

        return response()->noContent();
    }
}