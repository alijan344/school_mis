<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChartofaccountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'account_id' => $this->account_id,
            'account_name' => $this->account_name,
            'expenses' => ExpenseResource::collection(
                $this->whenLoaded('expenses')
            ),
        ];
    }
}