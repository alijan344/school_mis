<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockOut;
use App\Http\Requests\StoreStockOutRequest;
use App\Http\Requests\UpdateStockOutRequest;
use App\Http\Resources\StockOutResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockOutController extends Controller
{
    public function index(Request $request)
    {
        $query = StockOut::query()->with('stock');

        foreach (['stock_id', 'out_date'] as $field) {
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
            'stock_out_id',
            'stock_id',
            'out_date',
            'out_quantity',
        ];

        $sort = $request->query('sort', 'stock_out_id');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'stock_out_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return StockOutResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreStockOutRequest $request)
    {
        $data = $request->validated();

        $record = DB::transaction(function () use ($data) {
            $stock = Stock::where('stock_id', $data['stock_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($stock->quantity < $data['out_quantity']) {
                throw ValidationException::withMessages([
                    'out_quantity' => ['Insufficient stock quantity.'],
                ]);
            }

            $record = StockOut::create($data);

            $stock->decrement('quantity', $data['out_quantity']);

            return $record;
        });

        return (new StockOutResource($record->load('stock')))
            ->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        return new StockOutResource(
            StockOut::with('stock')->findOrFail($id)
        );
    }

    public function update(UpdateStockOutRequest $request, string $id)
    {
        $data = $request->validated();

        $record = DB::transaction(function () use ($data, $id) {
            $record = StockOut::where('stock_out_id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $oldStockId = $record->stock_id;
            $oldQuantity = $record->out_quantity;

            $newStockId = $data['stock_id'] ?? $oldStockId;
            $newQuantity = $data['out_quantity'] ?? $oldQuantity;

            $stockIds = array_unique([$oldStockId, $newStockId]);
            sort($stockIds);

            $stocks = Stock::whereIn('stock_id', $stockIds)
                ->orderBy('stock_id')
                ->lockForUpdate()
                ->get()
                ->keyBy('stock_id');

            $oldStock = $stocks[$oldStockId];
            $newStock = $stocks[$newStockId];

            $available = $newStock->quantity;

            if ($oldStockId == $newStockId) {
                $available += $oldQuantity;
            }

            if ($available < $newQuantity) {
                throw ValidationException::withMessages([
                    'out_quantity' => ['Insufficient stock quantity.'],
                ]);
            }

            $oldStock->increment('quantity', $oldQuantity);
            $newStock->decrement('quantity', $newQuantity);

            $record->update($data);

            return $record;
        });

        return new StockOutResource(
            $record->fresh()->load('stock')
        );
    }

    public function destroy(string $id): JsonResponse
    {
        DB::transaction(function () use ($id) {
            $record = StockOut::where('stock_out_id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $stock = Stock::where('stock_id', $record->stock_id)
                ->lockForUpdate()
                ->firstOrFail();

            $stock->increment('quantity', $record->out_quantity);
            $record->delete();
        });

        return response()->noContent();
    }
}