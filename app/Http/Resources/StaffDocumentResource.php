<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffDocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'document_id' => $this->document_id,
            'staff_id' => $this->staff_id,
            'document_name' => $this->document_name,
            'document_file' => $this->document_file,
            'upload_date' => $this->upload_date,

            'staff' => $this->whenLoaded(
                'staff',
                fn () => $this->staff ? [
                    'staff_id' => $this->staff->staff_id,
                    'firstname' => $this->staff->firstname,
                    'lastname' => $this->staff->lastname,
                ] : null
            ),
        ];
    }
}