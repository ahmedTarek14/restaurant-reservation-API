<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int)$this->id,
            'customer_id' => (int)$this->reservations()->latest()->first()->customer->id,
            'customer_name' => (string)$this->reservations()->latest()->first()->customer->name,
            'customer_phone' => (string)$this->reservations()->latest()->first()->customer->phone,
            'from_time' => Carbon::parse($this->from_time)->format('d-m-Y H:i'),
            'to_time' => Carbon::parse($this->to_time)->format('d-m-Y H:i'),
        ];
    }
}