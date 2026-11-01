<?php

namespace App\Http\Controllers;

use App\Models\StudentDocument;
use App\Http\Requests\StoreStudentDocumentRequest;
use App\Http\Requests\UpdateStudentDocumentRequest;
use App\Http\Resources\StudentDocumentResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentDocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentDocument::query()->with('student');

        foreach (['student_id', 'upload_date'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->query($field));
            }
        }

        $query->when($request->query('search'), function ($q, $term) {
            $q->where('document_name', 'like', "%{$term}%");
        });

        $sortable = [
            'document_id',
            'student_id',
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

        return StudentDocumentResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreStudentDocumentRequest $request)
    {
        $document = StudentDocument::create($request->validated());

        return (new StudentDocumentResource(
            $document->load('student')
        ))->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $document = StudentDocument::with('student')->findOrFail($id);

        return new StudentDocumentResource($document);
    }

    public function update(
        UpdateStudentDocumentRequest $request,
        string $id
    ) {
        $document = StudentDocument::findOrFail($id);
        $document->update($request->validated());

        return new StudentDocumentResource(
            $document->fresh()->load('student')
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $document = StudentDocument::findOrFail($id);
        $document->delete();

        return response()->noContent();
    }
}