<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->total . ' ' . $this->currency->code,
            'quantity' => $this->quantity,
            'item' => ItemResource::make($this->item),
            'date' => $this->created_at->format('M-d H:i'),
        ];
    }
}
