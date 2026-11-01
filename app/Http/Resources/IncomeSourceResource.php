<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeSourceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'source_id' => $this->source_id,
            'source_name' => $this->source_name,
            'incomes' => IncomeResource::collection(
                $this->whenLoaded('incomes')
            ),
            'other_incomes' => OtherIncomeResource::collection(
                $this->whenLoaded('otherIncomes')
            ),
        ];
    }
}