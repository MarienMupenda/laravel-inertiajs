<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */


    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->product->name??'',
            'slug' => $this->slug,
            'description' => $this->product->description??'',
            'price' => $this->price,
            'image' => $this->image(),
            'image_small' => $this->imageSmall(),
            'category' => $this->category->name??'',
            'currency' => $this->getCurrencySymbol(),
            'company' => $this->company->name??'',
            //'visits' => $this->visits(),
            'status' => $this->status,
            'link' => route('items.show', $this->slug),
        ];


    }
}
