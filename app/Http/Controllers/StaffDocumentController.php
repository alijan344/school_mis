<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStaffDocumentRequest;
use App\Http\Requests\UpdateStaffDocumentRequest;
use App\Http\Resources\StaffDocumentResource;
use App\Models\StaffDocument;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StaffDocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = StaffDocument::query()->with('staff');

        foreach (['staff_id', 'upload_date'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->query($field));
            }
        }

        $query->when($request->query('search'), function ($q, $term) {
            $q->where('document_name', 'like', "%{$term}%");
        });

        $sortable = [
            'document_id',
            'staff_id',
            'document_name',
            'upload_date',
        ];

        $sort = $request->query('sort', 'document_id');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'document_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return StaffDocumentResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreStaffDocumentRequest $request)
    {
        $document = StaffDocument::create($request->validated());

        return (new StaffDocumentResource(
            $document->load('staff')
        ))->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $document = StaffDocument::with('staff')->findOrFail($id);

        return new StaffDocumentResource($document);
    }

    public function update(
        UpdateStaffDocumentRequest $request,
        string $id
    ) {
        $document = StaffDocument::findOrFail($id);
        $document->update($request->validated());

        return new StaffDocumentResource(
            $document->fresh()->load('staff')
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $document = StaffDocument::findOrFail($id);
        $document->delete();

        return response()->noContent();
    }
}