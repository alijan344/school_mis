<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'class_id' => $this->class_id,
            'class_name' => $this->class_name,
            'fees' => $this->fees,
            'sections' => ClassSectionResource::collection(
                $this->whenLoaded('sections')
            ),
        ];
    }
}