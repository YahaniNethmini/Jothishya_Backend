<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AstrologerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'contact_no' => $this->contact_no,
            'primary_skill' => $this->primary_skill,
            'experience_years' => $this->experience_years,
            'availability_status' => $this->availability_status,
            'profile_image' => $this->profile_image
                ? asset('storage/' . $this->profile_image)
                : null,
            'rates' => [
                'chat' => $this->chat_rate,
                'call' => $this->call_rate,
                'video_call' => $this->video_call_rate,
                'report' => $this->report_rate
            ],
            'verification' => [
                'is_verified' => $this->is_verified,
                'verification_date' => $this->verification_date
            ]
        ];
    }
}
