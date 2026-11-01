<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockIn;
use App\Http\Requests\StoreStockInRequest;
use App\Http\Requests\UpdateStockInRequest;
use App\Http\Resources\StockInResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    public function index(Request $request)
    {
        $query = StockIn::query()->with('stock');

        foreach (['stock_id', 'in_date'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->query($field));
            }
        }

        $query->when($request->query('search'), function ($q, $term) {
            $q->where(function ($inner) use ($term) {
                $inner->where('remark', 'like', "%{$term}%")
                    ->orWhereHas('stock', function ($stock) use ($term) {
                        $stock->where('item_name', 'like', "%{$term}%");
                    });
            });
        });

        $sortable = [
            'stock_in_id',
            'stock_id',
            'in_date',
            'in_quantity',
        ];

        $sort = $request->query('sort', 'stock_in_id');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'stock_in_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return StockInResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreStockInRequest $request)
    {
        $data = $request->validated();

        $record = DB::transaction(function () use ($data) {
            $stock = Stock::where('stock_id', $data['stock_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $record = StockIn::create($data);

            $stock->increment('quantity', $data['in_quantity']);

            return $record;
        });

        return (new StockInResource($record->load('stock')))
            ->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        return new StockInResource(
            StockIn::with('stock')->findOrFail($id)
        );
    }

    public function update(UpdateStockInRequest $request, string $id)
    {
        $data = $request->validated();

        $record = DB::transaction(function () use ($data, $id) {
            $record = StockIn::where('stock_in_id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $oldStockId = $record->stock_id;
            $oldQuantity = $record->in_quantity;

            $newStockId = $data['stock_id'] ?? $oldStockId;
            $newQuantity = $data['in_quantity'] ?? $oldQuantity;

            $stockIds = array_unique([$oldStockId, $newStockId]);
            sort($stockIds);

            $stocks = Stock::whereIn('stock_id', $stockIds)
                ->orderBy('stock_id')
                ->lockForUpdate()
                ->get()
                ->keyBy('stock_id');

            $stocks[$oldStockId]->decrement('quantity', $oldQuantity);
            $stocks[$newStockId]->increment('quantity', $newQuantity);

            $record->update($data);

            return $record;
        });

        return new StockInResource(
            $record->fresh()->load('stock')
        );
    }

    public function destroy(string $id): JsonResponse
    {
        DB::transaction(function () use ($id) {
            $record = StockIn::where('stock_in_id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $stock = Stock::where('stock_id', $record->stock_id)
                ->lockForUpdate()
                ->firstOrFail();

            $stock->decrement('quantity', $record->in_quantity);
            $record->delete();
        });

        return response()->noContent();
    }
}