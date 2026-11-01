<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherAttendanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'teacher_id' => $this->teacher_id,
            'absent_year' => $this->absent_year,
            'absent_month' => $this->absent_month,
            'absent_day' => $this->absent_day,
            'remark' => $this->remark,

            'teacher' => $this->whenLoaded(
                'teacher',
                fn () => $this->teacher ? [
                    'teacher_id' => $this->teacher->teacher_id,
                    'firstname' => $this->teacher->firstname,
                    'lastname' => $this->teacher->lastname,
                ] : null
            ),
        ];
    }
}