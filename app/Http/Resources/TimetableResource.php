<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimetableResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'weekday' => $this->weekday,
            'lesson_hour' => $this->lesson_hour,
            'teacher_id' => $this->teacher_id,
            'subject_id' => $this->subject_id,
            'section_id' => $this->section_id,

            'teacher' => $this->whenLoaded(
                'teacher',
                fn () => $this->teacher ? [
                    'teacher_id' => $this->teacher->teacher_id,
                    'firstname' => $this->teacher->firstname,
                    'lastname' => $this->teacher->lastname,
                ] : null
            ),

            'subject' => $this->whenLoaded(
                'subject',
                fn () => $this->subject ? [
                    'subject_id' => $this->subject->subject_id,
                    'subject_name' => $this->subject->subject_name,
                ] : null
            ),

            'class_section' => $this->whenLoaded(
                'classSection',
                fn () => $this->classSection ? [
                    'section_id' => $this->classSection->section_id,
                    'section_name' => $this->classSection->section_name,
                    'class_id' => $this->classSection->class_id,
                ] : null
            ),
        ];
    }
}