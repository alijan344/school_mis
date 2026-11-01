<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Http\Resources\PurchaseResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Purchase::query()->with('staff');

        $query->when($request->filled('staff_id'), function ($q) use ($request) {
            $q->where('staff_id', $request->query('staff_id'));
        });

        $query->when($request->filled('purchase_date'), function ($q) use ($request) {
            $q->whereDate('purchase_date', $request->query('purchase_date'));
        });

        $query->when($request->query('search'), function ($q, $term) {
            $q->where(function ($inner) use ($term) {
                $inner->where('item_name', 'like', "%{$term}%")
                    ->orWhere('unit', 'like', "%{$term}%");
            });
        });

        $sortable = [
            'purchase_id',
            'staff_id',
            'purchase_date',
            'item_name',
            'quantity',
            'unitprice',
            'totalprice',
        ];

        $sort = $request->query('sort', 'purchase_id');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'purchase_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return PurchaseResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StorePurchaseRequest $request)
    {
        $purchase = Purchase::create($request->validated());

        return (new PurchaseResource($purchase->load('staff')))
            ->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $purchase = Purchase::with('staff')->findOrFail($id);

        return new PurchaseResource($purchase);
    }

    public function update(UpdatePurchaseRequest $request, string $id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->update($request->validated());

        return new PurchaseResource(
            $purchase->fresh()->load('staff')
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();

        return response()->noContent();
    }
}