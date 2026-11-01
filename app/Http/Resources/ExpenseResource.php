<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'expense_id' => $this->expense_id,
            'account_id' => $this->account_id,
            'expense_amount' => $this->expense_amount,
            'expense_date' => $this->expense_date,
            'remark' => $this->remark,
            'chartofaccount' => $this->whenLoaded(
                'chartofaccount',
                fn () => new ChartofaccountResource($this->chartofaccount)
            ),
        ];
    }
}