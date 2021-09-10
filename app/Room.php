<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }

    public function sessions()
    {
        return $this->hasMany('App\Session');
    }
}
