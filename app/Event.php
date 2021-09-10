<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function organizer()
    {
        return $this->belongsTo('App\Organizer');
    }

    public function channels()
    {
        return $this->hasMany('App\Channel');
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    public function rooms()
    {
        return $this->hasManyThrough('App\Room', 'App\Channel');
    }

    public function registrations()
    {
        return $this->hasManyThrough('App\Registration', 'App\Ticket');
    }
}
