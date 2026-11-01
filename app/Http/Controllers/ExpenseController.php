<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::query()->with('chartofaccount');

        $query->when($request->filled('account_id'), function ($q) use ($request) {
            $q->where('account_id', $request->query('account_id'));
        });

        $query->when($request->filled('expense_date'), function ($q) use ($request) {
            $q->whereDate('expense_date', $request->query('expense_date'));
        });

        $query->when($request->query('search'), function ($q, $term) {
            $q->where(function ($inner) use ($term) {
                $inner->where('remark', 'like', "%{$term}%")
                    ->orWhereHas('chartofaccount', function ($account) use ($term) {
                        $account->where('account_name', 'like', "%{$term}%");
                    });
            });
        });

        $sortable = [
            'expense_id',
            'account_id',
            'expense_amount',
            'expense_date'
        ];

        $sort = $request->query('sort', 'expense_id');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'expense_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return ExpenseResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreExpenseRequest $request)
    {
        $expense = Expense::create($request->validated());

        return (new ExpenseResource($expense->load('chartofaccount')))
            ->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $expense = Expense::with('chartofaccount')->findOrFail($id);

        return new ExpenseResource($expense);
    }

    public function update(UpdateExpenseRequest $request, string $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->update($request->validated());

        return new ExpenseResource(
            $expense->fresh()->load('chartofaccount')
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return response()->noContent();
    }
}