<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeritaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'thumbnail' => $this->thumbnail ? url($this->thumbnail) : null,
            'status' => $this->status,
            'view_count' => $this->view_count,
            'author' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'kategoris' => $this->whenLoaded('kategoris', function () {
                return $this->kategoris->map(fn($k) => [
                    'id' => $k->id,
                    'name' => $k->name,
                ]);
            }),
            'tags' => $this->whenLoaded('tags', function () {
                return $this->tags->map(fn($t) => [
                    'id' => $t->id,
                    'name' => $t->name,
                ]);
            }),
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}