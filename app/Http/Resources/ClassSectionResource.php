<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassSectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'section_id' => $this->section_id,
            'section_name' => $this->section_name,
            'class_id' => $this->class_id,
            'school_class' => $this->whenLoaded(
                'schoolClass',
                fn () => new ClassResource($this->schoolClass)
            ),
        ];
    }
}