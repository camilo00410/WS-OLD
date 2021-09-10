<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Organizer extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    public $timestamps = false;

    public function events()
    {
        return $this->hasMany('App\Event');
    }
}
