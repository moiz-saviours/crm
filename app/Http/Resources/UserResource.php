<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'image' => $this->image ? asset('assets/images/employees/' . $this->image) : null,
            "phone" => "1234567890",
            "ip_address" => null,
            "status" => 1,
            "deleted_at" => null,
            "updated_at" => "2025-02-06T17:42:05.000000Z",
            "created_at" => "2025-02-04T18:50:32.000000Z"
        ];
    }
}
