<?php

namespace App\Http\Resources;

use App\Ticket;
use App\SessionRegistration;
use App\Http\Resources\Event as EventResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Registration extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $ticket = Ticket::find($this->id);

//        $list = SessionRegistration::where('registration_id')

        return [
            'event' => new EventResource($ticket->event),
//            'session_ids' =>
        ];
//        return parent::toArray($request);
    }
}
