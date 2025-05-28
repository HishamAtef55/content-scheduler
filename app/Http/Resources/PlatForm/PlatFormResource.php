<?php

namespace App\Http\Resources\PlatForm;

use App\Enums\Status;
use Illuminate\Http\Request;
use App\Http\Resources\Post\PostResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PlatFormResource extends JsonResource
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
            'name' => $this->name,
            'icon' => $this->icon,
            // 'posts' => PostResource::collection($this->whenLoaded('posts')),

        ];
    }
}
