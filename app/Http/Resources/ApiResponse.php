<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponse extends JsonResource
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
            'data' => $this->data ?? null,
            'error' => $this->error ?? null,
            'message' => $this->message ?? null,
        ];

    }
}
