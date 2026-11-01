<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffAttendanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'staff_id' => $this->staff_id,
            'absent_year' => $this->absent_year,
            'absent_month' => $this->absent_month,
            'absent_day' => $this->absent_day,
            'remark' => $this->remark,

            'staff' => $this->whenLoaded(
                'staff',
                fn () => $this->staff ? [
                    'staff_id' => $this->staff->staff_id,
                    'firstname' => $this->staff->firstname,
                    'lastname' => $this->staff->lastname,
                ] : null
            ),
        ];
    }
}