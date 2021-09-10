<?php

namespace App\Http\Resources;

use App\Http\Resources\Room as RoomResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Channel extends JsonResource
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
            'rooms' => RoomResource::collection($this->rooms)
        ];
//        return parent::toArray($request);
    }
}
