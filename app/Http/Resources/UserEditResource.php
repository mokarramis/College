<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserEditResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->roles->map(function($item){
                return [
                    'name' => $item->name,
                    'display_name' => $item->display_name,
                    'description' => $item->description
                ];
            }),
            'permissions' => $this->permissions->map(function($item){
                return [
                    'name' => $item->name,
                    'display_name' => $item->display_name,
                    'description' => $item->description
                ];
            })
        ];
    }
}
