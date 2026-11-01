<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LibMemberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'student_id' => $this->student_id,
            'reg_date' => $this->reg_date,

            'student' => $this->whenLoaded(
                'student',
                fn () => [
                    'student_id' => $this->student->student_id,
                    'firstname' => $this->student->firstname,
                    'fathername' => $this->student->fathername,
                    'grandfathername' => $this->student->grandfathername,
                ]
            ),

            'loans' => LibLoanResource::collection(
                $this->whenLoaded('loans')
            ),
        ];
    }
}