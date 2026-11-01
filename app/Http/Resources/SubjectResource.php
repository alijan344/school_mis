<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'subject_id' => $this->subject_id,
            'subject_name' => $this->subject_name,

            'timetables' => TimetableResource::collection(
                $this->whenLoaded('timetables')
            ),

            'scores' => ScoreResource::collection(
                $this->whenLoaded('scores')
            ),
        ];
    }
}