<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            
            'item' => $this->map(function($item){
                return [
                    'term_id' => $item->term_id,
                    'file' => $item->file,
                    'video' => $item->video
                ];
            })
        ];
    }
}
