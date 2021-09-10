<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function room()
    {
        return $this->belongsTo('App\Room');
    }

    public function registrations()
    {
        return $this->hasMany('App\SessionRegistration');
    }
}
