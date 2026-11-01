<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentTransferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'transfer_id' => $this->transfer_id,
            'student_id' => $this->student_id,
            'transfer_date' => $this->transfer_date,
            'transfer_no' => $this->transfer_no,
            'school_name' => $this->school_name,
            'transfer_type' => $this->transfer_type,

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