<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherDocumentRequest;
use App\Http\Requests\UpdateTeacherDocumentRequest;
use App\Http\Resources\TeacherDocumentResource;
use App\Models\TeacherDocument;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TeacherDocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = TeacherDocument::query()->with('teacher');

        foreach (['teacher_id', 'upload_date'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->query($field));
            }
        }

        $query->when($request->query('search'), function ($q, $term) {
            $q->where('document_name', 'like', "%{$term}%");
        });

        $sortable = [
            'document_id',
            'teacher_id',
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

        return TeacherDocumentResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreTeacherDocumentRequest $request)
    {
        $document = TeacherDocument::create($request->validated());

        return (new TeacherDocumentResource(
            $document->load('teacher')
        ))->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $document = TeacherDocument::with('teacher')->findOrFail($id);

        return new TeacherDocumentResource($document);
    }

    public function update(
        UpdateTeacherDocumentRequest $request,
        string $id
    ) {
        $document = TeacherDocument::findOrFail($id);
        $document->update($request->validated());

        return new TeacherDocumentResource(
            $document->fresh()->load('teacher')
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $document = TeacherDocument::findOrFail($id);
        $document->delete();

        return response()->noContent();
    }
}