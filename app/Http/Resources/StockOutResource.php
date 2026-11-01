<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockOutResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'stock_out_id' => $this->stock_out_id,
            'stock_id' => $this->stock_id,
            'out_date' => $this->out_date,
            'out_quantity' => $this->out_quantity,
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