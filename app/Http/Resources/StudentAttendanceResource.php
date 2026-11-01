<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentAttendanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'student_id' => $this->student_id,
            'absent_date' => $this->absent_date,
            'absent_type' => $this->absent_type,

            'student' => $this->whenLoaded(
                'student',
                fn () => $this->student ? [
                    'student_id' => $this->student->student_id,
                    'firstname' => $this->student->firstname,
                    'fathername' => $this->student->fathername,
                ] : null
            ),
        ];
    }
}