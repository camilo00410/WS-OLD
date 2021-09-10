<?php

namespace App\Http\Controllers;

use App\Attendee;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function findUser(Request $request)
    {
        return Attendee::whereNotNull('login_token')->where('login_token', $request->token)->first();
    }
}
