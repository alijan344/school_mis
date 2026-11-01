<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherSalaryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'teacher_id' => $this->teacher_id,
            'salary_year' => $this->salary_year,
            'salary_month' => $this->salary_month,
            'tax_amount' => $this->tax_amount,
            'absent_amount' => $this->absent_amount,
            'loan_amount' => $this->loan_amount,
            'non_absent_bonus' => $this->non_absent_bonus,
            'bonus' => $this->bonus,
            'payable_salary' => $this->payable_salary,
            'guarantee' => $this->guarantee,
            'net_salary' => $this->net_salary,
            'pay_date' => $this->pay_date,

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