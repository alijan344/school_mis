<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLevelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'staff_id' => $this->staff_id,
            'admin_level' => $this->admin_level,
            'academic_level' => $this->academic_level,
            'student_level' => $this->student_level,
            'teacher_level' => $this->teacher_level,
            'staff_level' => $this->staff_level,
            'finance_level' => $this->finance_level,
            'library_level' => $this->library_level,
            'stock_level' => $this->stock_level,
            'IT_level' => $this->IT_level,

            'user' => $this->whenLoaded(
                'user',
                fn () => $this->user ? [
                    'staff_id' => $this->user->staff_id,
                    'username' => $this->user->username,
                ] : null
            ),
        ];
    }
}