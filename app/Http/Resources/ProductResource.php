<?php

namespace App\Http\Resources;

use App\Enums\UserType;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Product Resource for Return Resource Into An Array
 */
class ProductResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->getPrice(),
            'image' => $this->image,
            'active' => $this->active,
            'created_at' => $this->created_at
        ];
    }
}
