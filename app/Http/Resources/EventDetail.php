<?php

namespace App\Http\Resources;

use App\Http\Resources\Channel as ChannelResource;
use App\Http\Resources\Ticket as TicketResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EventDetail extends JsonResource
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
            'channels' => ChannelResource::collection($this->channels),
            'tickets' => TicketResource::collection($this->tickets),
        ];
//        return parent::toArray($request);
    }
}
