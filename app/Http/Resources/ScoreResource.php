<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScoreResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'student_id' => $this->student_id,
            'subject_id' => $this->subject_id,
            'exam_year' => $this->exam_year,
            'section_id' => $this->section_id,
            'mid_exam' => $this->mid_exam,
            'final_exam' => $this->final_exam,
            'second_chance' => $this->second_chance,
            'total_mark' => $this->total_mark,

            'student' => $this->whenLoaded(
                'student',
                fn () => [
                    'student_id' => $this->student->student_id,
                    'firstname' => $this->student->firstname,
                    'fathername' => $this->student->fathername,
                ]
            ),

            'subject' => $this->whenLoaded(
                'subject',
                fn () => [
                    'subject_id' => $this->subject->subject_id,
                    'subject_name' => $this->subject->subject_name,
                ]
            ),

            'class_section' => $this->whenLoaded(
                'classSection',
                fn () => [
                    'section_id' => $this->classSection->section_id,
                    'section_name' => $this->classSection->section_name,
                    'class_id' => $this->classSection->class_id,
                ]
            ),
        ];
    }
}