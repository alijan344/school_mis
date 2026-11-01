<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'staff_id' => $this->staff_id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'fathername' => $this->fathername,
            'gender' => $this->gender,
            'birth_year' => $this->birth_year,
            'photo' => $this->photo,
            'phone' => $this->phone,
            'email' => $this->email,
            'province' => $this->province,
            'district' => $this->district,
            'village' => $this->village,
            'current_address' => $this->current_address,
            'position' => $this->position,
            'gross_salary' => $this->gross_salary,
            'status' => $this->status,

            'documents' => StaffDocumentResource::collection(
                $this->whenLoaded('documents')
            ),

            'attendances' => StaffAttendanceResource::collection(
                $this->whenLoaded('attendances')
            ),

            'salaries' => StaffSalaryResource::collection(
                $this->whenLoaded('salaries')
            ),
        ];
    }
}