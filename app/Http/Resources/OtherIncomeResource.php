<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OtherIncomeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'income_id' => $this->income_id,
            'source_id' => $this->source_id,
            'income_amount' => $this->income_amount,
            'income_date' => $this->income_date,
        ];
    }
}