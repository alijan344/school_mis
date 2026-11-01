<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'stock_id' => $this->stock_id,
            'item_name' => $this->item_name,
            'unit' => $this->unit,
            'quantity' => $this->quantity,

            'stock_ins' => StockInResource::collection(
                $this->whenLoaded('stockIns')
            ),

            'stock_outs' => StockOutResource::collection(
                $this->whenLoaded('stockOuts')
            ),
        ];
    }
}