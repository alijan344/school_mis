<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentRelativeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'relative_id' => $this->relative_id,
            'student_id' => $this->student_id,
            'relative_name' => $this->relative_name,
            'relative_phone' => $this->relative_phone,
            'relative_relation' => $this->relative_relation,

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