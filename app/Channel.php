<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function rooms()
    {
        return $this->hasMany('App\Room');
    }

    public function sessions()
    {
        return $this->hasManyThrough('App\Session', 'App\Room');
    }
}
