<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Attendee as AttendeeResource;
use App\Attendee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $user = Attendee::where([
            ['lastname', $request->lastname],
            ['registration_code', $request->registration_code]
        ])->first();

        if ($user) {
            $user->login_token = md5($user->username);
            $user->save();

            return response()->json(new AttendeeResource($user), 200);
        }

        return response()->json([
            'message' => 'Invalid login'
        ], 401);
    }

    public function logout(Request $request)
    {
        $user = $this->findUser($request);

        if ($user) {
            $user->login_token = '';
            $user->save();

            return response()->json([
                'message' => 'Logout success'
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid token'
        ], 401);
    }
}
