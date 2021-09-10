<?php

namespace App\Http\Resources;

use App\Registration;
use Illuminate\Http\Resources\Json\JsonResource;

class Ticket extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $val = json_decode($this->special_validity);
        $description = null;
        $available = true;

        if ($val) {
            if ($val->type == 'amount') {
                $cnt = Registration::where('ticket_id', $this->id)->count();
                $description = $val->amount . ' tickets available';
                if ($val->amount <= $cnt) {
                    $available = false;
                }
            } else if ($val->type == 'date') {
                $today = new \DateTime(date('Y-m-d'));
                $date = new \DateTime($val->date);
                $description = 'Available until ' . date_format($date, 'F ') . (int)date_format($date, 'd') . date_format($date, ', Y');

                if ($today >= $date) {
                    $available = false;
                }
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $description,
            'cost' => (int)$this->cost,
            'available' => $available,
        ];
//        return parent::toArray($request);
    }
}
