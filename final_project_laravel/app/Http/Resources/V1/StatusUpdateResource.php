<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusUpdateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status,
            'comment' => $this->comment,
            'updated_at' => $this->created_at->toDateTimeString(),
            'updated_by' => $this->updater ? $this->updater->name : 'System',
        ];
    }
}
