<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxonomyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'term_id' => $this->term_id,
            'taxonomy_name' => $this->taxonomy_name,
            'description' => $this->description,
            'taxonomy_parent' => $this->taxonomy_parent,
        ];
    }
}
