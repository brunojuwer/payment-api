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
            'identify' => $this->id,
            'name' => strtoupper($this->full_name),
            'cpf' => $this->cpf,
            'email' => $this->email,
            'nationality' => $this->nationality,
            'contact' => $this->contact_number,
            'birth' => $this->birth_date,
            'created' => $this->created_at,
            'account' => $this->account($this->id)
        ];
    }
}
