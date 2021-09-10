<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public $table = 'event_tickets';

    public $timestamps = false;

    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
