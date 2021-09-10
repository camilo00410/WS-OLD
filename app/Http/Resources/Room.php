<?php

namespace App\Http\Resources;

use App\Http\Resources\Session as SessionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Room extends JsonResource
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
            'name' => $this->name,
            'sessions' => SessionResource::collection($this->sessions)
        ];
//        return parent::toArray($request);
    }
}
