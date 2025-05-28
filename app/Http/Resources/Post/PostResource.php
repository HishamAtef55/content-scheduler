<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\PlatForm\PlatFormResource;
use App\Models\Platform;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'platform' => PlatFormResource::make($this->whenLoaded('platform')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
            'scheduled_at' => $this->scheduled_at,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
