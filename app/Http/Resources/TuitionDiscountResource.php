<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TuitionDiscountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'student_id' => $this->student_id,
            'discount_year' => $this->discount_year,
            'section_id' => $this->section_id,
            'discount_amount' => $this->discount_amount,
            'discount_type' => $this->discount_type,

            'student' => $this->whenLoaded(
                'student',
                fn () => $this->student ? [
                    'student_id' => $this->student->student_id,
                    'firstname' => $this->student->firstname,
                    'fathername' => $this->student->fathername,
                ] : null
            ),

            'class_section' => $this->whenLoaded(
                'classSection',
                fn () => $this->classSection ? [
                    'section_id' => $this->classSection->section_id,
                    'section_name' => $this->classSection->section_name,
                    'class_id' => $this->classSection->class_id,
                ] : null
            ),
        ];
    }
}