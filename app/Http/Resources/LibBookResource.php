<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LibBookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'book_id' => $this->book_id,
            'isbn' => $this->isbn,
            'book_name' => $this->book_name,
            'author' => $this->author,
            'publish_year' => $this->publish_year,
            'publisher' => $this->publisher,
            'shelf' => $this->shelf,
            'shelf_row' => $this->shelf_row,
            'loans' => LibLoanResource::collection(
                $this->whenLoaded('loans')
            ),
        ];
    }
}