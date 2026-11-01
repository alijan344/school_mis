<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherDocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'document_id' => $this->document_id,
            'teacher_id' => $this->teacher_id,
            'document_name' => $this->document_name,
            'document_file' => $this->document_file,
            'upload_date' => $this->upload_date,

            'teacher' => $this->whenLoaded(
                'teacher',
                fn () => $this->teacher ? [
                    'teacher_id' => $this->teacher->teacher_id,
                    'firstname' => $this->teacher->firstname,
                    'lastname' => $this->teacher->lastname,
                ] : null
            ),
        ];
    }
}