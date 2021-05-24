<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'url' => $this->url,
            'private_url' => $this->private_url,
            'type' => $this->type,
            'dir' => $this->dir,
            'is_public' => $this->is_public,
            'user' => $this->user,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
