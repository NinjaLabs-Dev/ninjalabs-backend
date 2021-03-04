<?php

namespace App\Http\Resources;

use App\Models\Image;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowsResource extends JsonResource
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
            'slug' => $this->slug,
            'image' => Image::findOrFail($this->image_id)
        ];
    }
}
