<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'purchase_id' => $this->purchase_id,
            'staff_id' => $this->staff_id,
            'purchase_date' => $this->purchase_date,
            'item_name' => $this->item_name,
            'unit' => $this->unit,
            'quantity' => $this->quantity,
            'unitprice' => $this->unitprice,
            'totalprice' => $this->totalprice,

            'staff' => $this->whenLoaded(
                'staff',
                fn () => [
                    'staff_id' => $this->staff->staff_id,
                    'firstname' => $this->staff->firstname,
                    'lastname' => $this->staff->lastname,
                ]
            ),
        ];
    }
}