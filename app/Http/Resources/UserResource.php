<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

/**
 * User Resource for Return Resource Into An Array
 */
class UserResource extends JsonResource
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
            'username' => $this->username,
            'email' => $this->email,
            'type' => $this->type,
            'image' => $this->image,
            'created_at' => $this->created_at,
        ];
    }
}
