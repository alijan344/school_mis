<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffSalaryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'staff_id' => $this->staff_id,
            'salary_year' => $this->salary_year,
            'salary_month' => $this->salary_month,
            'absent_amount' => $this->absent_amount,
            'bonus' => $this->bonus,
            'tax_amount' => $this->tax_amount,
            'payable_salary' => $this->payable_salary,
            'guarantee' => $this->guarantee,
            'net_salary' => $this->net_salary,
            'pay_date' => $this->pay_date,

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