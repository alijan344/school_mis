<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Http\Resources\StaffResource;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::query()->with([
            'documents',
            'attendances',
            'salaries',
        ]);

        $query->when($request->filled('status'), function ($q) use ($request) {
            $q->where('status', $request->query('status'));
        });

        $query->when($request->filled('position'), function ($q) use ($request) {
            $q->where('position', $request->query('position'));
        });

        $query->when($request->query('search'), function ($q, $term) {
            $q->where(function ($inner) use ($term) {
                $inner->where('firstname', 'like', "%{$term}%")
                    ->orWhere('lastname', 'like', "%{$term}%")
                    ->orWhere('fathername', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%");
            });
        });

        $sortable = [
            'staff_id',
            'firstname',
            'lastname',
            'position',
            'status',
            'gross_salary',
            'birth_year',
        ];

        $sort = $request->query('sort', 'staff_id');
        $direction = $request->query('direction', 'asc');

        if (!in_array($sort, $sortable, true)) {
            $sort = 'staff_id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $query->orderBy($sort, $direction);

        $perPage = min(100, max(1, (int) $request->query('per_page', 15)));

        return StaffResource::collection(
            $query->paginate($perPage)->withQueryString()
        );
    }

    public function store(StoreStaffRequest $request)
    {
        $staff = Staff::create($request->validated());

        return (new StaffResource($staff))
            ->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $staff = Staff::with([
            'documents',
            'attendances',
            'salaries',
        ])->findOrFail($id);

        return new StaffResource($staff);
    }

    public function update(UpdateStaffRequest $request, string $id)
    {
        $staff = Staff::findOrFail($id);
        $staff->update($request->validated());

        return new StaffResource(
            $staff->fresh()->load([
                'documents',
                'attendances',
                'salaries',
            ])
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $staff = Staff::findOrFail($id);

        if (
            $staff->documents()->exists() ||
            $staff->attendances()->exists() ||
            $staff->salaries()->exists()
        ) {
            return response()->json([
                'message' => 'This staff member cannot be deleted because related records exist.',
                'errors' => new \stdClass(),
            ], 409);
        }

        $staff->delete();

        return response()->noContent();
    }
}