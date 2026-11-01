<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'student_id' => $this->student_id,
            'reg_no' => $this->reg_no,
            'firstname' => $this->firstname,
            'fathername' => $this->fathername,
            'grandfathername' => $this->grandfathername,
            'gender' => $this->gender,
            'birth_year' => $this->birth_year,
            'province' => $this->province,
            'district' => $this->district,
            'current_address' => $this->current_address,
            'nic' => $this->nic,
            'phone' => $this->phone,
            'photo' => $this->photo,
            'status' => $this->status,
            'section_id' => $this->section_id,

            'class_section' => $this->whenLoaded(
                'classSection',
                fn () => new ClassSectionResource($this->classSection)
            ),

            'relatives' => StudentRelativeResource::collection(
                $this->whenLoaded('relatives')
            ),

            'transfers' => StudentTransferResource::collection(
                $this->whenLoaded('transfers')
            ),

            'documents' => StudentDocumentResource::collection(
                $this->whenLoaded('documents')
            ),

            'attendances' => StudentAttendanceResource::collection(
                $this->whenLoaded('attendances')
            ),
        ];
    }
}