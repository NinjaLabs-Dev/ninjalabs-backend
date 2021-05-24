<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomImageResource extends JsonResource
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
            'id' => $this->image->id,
            'custom_id' => $this->id,
            'slug' => $this->image->slug,
            'custom_slug' => $this->slug,
            'url' => $this->image->url,
            'private_url' => $this->image->private_url,
            'type' => $this->image->type,
            'dir' => $this->image->dir,
            'is_public' => $this->image->is_public,
            'user' => $this->user,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
