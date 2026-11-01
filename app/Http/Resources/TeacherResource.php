<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'teacher_id' => $this->teacher_id,
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
            'education_degree' => $this->education_degree,
            'education_field' => $this->education_field,
            'education_university' => $this->education_university,
            'education_year' => $this->education_year,
            'talent_score' => $this->talent_score,
            'gross_salary' => $this->gross_salary,
            'hod_bonus' => $this->hod_bonus,
            'academic_bonus' => $this->academic_bonus,
            'food_charge' => $this->food_charge,
            'talent_bonus' => $this->talent_bonus,
            'status' => $this->status,

            'documents' => TeacherDocumentResource::collection(
                $this->whenLoaded('documents')
            ),

            'attendances' => TeacherAttendanceResource::collection(
                $this->whenLoaded('attendances')
            ),

            'salaries' => TeacherSalaryResource::collection(
                $this->whenLoaded('salaries')
            ),

            'timetables' => TimetableResource::collection(
                $this->whenLoaded('timetables')
            ),
        ];
    }
}