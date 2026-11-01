<?php

namespace App\Http\Controllers;

use App\Models\LibBook;
use App\Http\Requests\StoreLibBookRequest;
use App\Http\Requests\UpdateLibBookRequest;
use App\Http\Resources\LibBookResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LibBookController extends Controller
{
    public function index(Request $request)
    {
        $query = LibBook::query()->with('loans');

        $query->when($request->filled('publish_year'), function ($q) use ($request) {
            $q->where('publish_year', $request->query('publish_year'));
        });

        $query->when($request->filled('shelf'), function ($q) use ($request) {
            $q->where('shelf', $request->query('shelf'));
        });

        $query->when($request->query('search'), function ($q, $term) {
            $q->where(function ($inner) use ($term) {
                $inner->where('book_name', 'like', "%{$term}%")
                    ->orWhere('author', 'like', "%{$term}%")
                    ->orWhere('isbn', 'like', "%{$term}%")
                    ->orWhere('publisher', 'like', "%{$term}%");
            });
        });

        $sortable = [
            'book_id',
            'book_name',
            'author',
            'publish_year',
            'publisher'
        ];

        $sort = $request->query('sort', 'book_id');
        $direction = $request->query('direction', 'asc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'book_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return LibBookResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreLibBookRequest $request)
    {
        $book = LibBook::create($request->validated());

        return (new LibBookResource($book))
            ->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $book = LibBook::with('loans')->findOrFail($id);

        return new LibBookResource($book);
    }

    public function update(UpdateLibBookRequest $request, string $id)
    {
        $book = LibBook::findOrFail($id);
        $book->update($request->validated());

        return new LibBookResource($book->fresh()->load('loans'));
    }

    public function destroy(string $id): JsonResponse
    {
        $book = LibBook::findOrFail($id);

        if ($book->loans()->exists()) {
            return response()->json([
                'message' => 'This book cannot be deleted because it has loan records.',
            ], 409);
        }

        $book->delete();

        return response()->noContent();
    }
}