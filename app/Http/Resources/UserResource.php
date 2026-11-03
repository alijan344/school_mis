<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'staff_id' => $this->staff_id,
            'username' => $this->username,

            'avatar_url' => $this->avatar_url,

            'staff' => $this->whenLoaded(
                'staff',
                fn () => $this->staff ? [
                    'staff_id' => $this->staff->staff_id,
                    'firstname' => $this->staff->firstname,
                    'lastname' => $this->staff->lastname,
                    'position' => $this->staff->position,
                    'status' => $this->staff->status,
                ] : null
            ),

            'user_level' => $this->whenLoaded(
                'userLevel',
                fn () => $this->userLevel
                    ? new UserLevelResource($this->userLevel)
                    : null
            ),
        ];
    }
}