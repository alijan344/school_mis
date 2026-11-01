<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentDocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'document_id' => $this->document_id,
            'student_id' => $this->student_id,
            'document_name' => $this->document_name,
            'document_file' => $this->document_file,
            'upload_date' => $this->upload_date,

            'student' => $this->whenLoaded(
                'student',
                fn () => $this->student ? [
                    'student_id' => $this->student->student_id,
                    'firstname' => $this->student->firstname,
                    'fathername' => $this->student->fathername,
                ] : null
            ),
        ];
    }
}