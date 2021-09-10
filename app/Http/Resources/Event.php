<?php

namespace App\Http\Resources;

use App\Http\Resources\Organizer as OrganizerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Event extends JsonResource
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
            'slug' => $this->slug,
            'date' => $this->date,
            'organizer' => new OrganizerResource($this->organizer)
        ];
    }
}
