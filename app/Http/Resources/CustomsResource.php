<?php

namespace App\Http\Resources;

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image_id' => $this->image_id,
            'image' => Image::findOrFail($this->image_id),
            'user' => User::findOrFail($this->user_id),
            'slug' => $this->slug
        ];
    }
}
