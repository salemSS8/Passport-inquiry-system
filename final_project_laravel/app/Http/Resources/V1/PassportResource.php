<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PassportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'serial_number' => $this->serial_number,
            'tracking_number' => $this->tracking_number,
            'national_id' => $this->national_id,
            'full_name' => $this->full_name,
            'status' => $this->status,
            'photo_url' => $this->photo_path ? asset('storage/' . $this->photo_path) : null,
            'branch' => new BranchResource($this->whenLoaded('branch')),
            'status_history' => StatusUpdateResource::collection($this->whenLoaded('statusUpdates')),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
