<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_id' => (int) $this->id,
            'total' => $this->total,
            'customer' => new CustomerResource($this->customer),
            'date' => Carbon::parse($this->from_time)->format('d-m-Y H:i'),
            'details' => InvoiceDetailsResource::collection($this->orderDetails)->response()->getData(true),
        ];
    }
}