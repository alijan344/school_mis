<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockInResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'stock_in_id' => $this->stock_in_id,
            'stock_id' => $this->stock_id,
            'in_date' => $this->in_date,
            'in_quantity' => $this->in_quantity,
            'remark' => $this->remark,

            'stock' => $this->whenLoaded(
                'stock',
                fn () => $this->stock ? [
                    'stock_id' => $this->stock->stock_id,
                    'item_name' => $this->stock->item_name,
                    'unit' => $this->stock->unit,
                    'quantity' => $this->stock->quantity,
                ] : null
            ),
        ];
    }
}