<?php

namespace App\Http\Controllers\Api;

use App\Ticket;
use App\Registration;
use App\Http\Resources\Registration as RegistrationResource;
use App\Http\Resources\Event as EventResource;
use App\Http\Resources\EventDetail as EventDetailResource;
use App\Organizer;
use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();

        return response()->json(EventResource::collection($events), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($oslug, $eslug)
    {
        $organizer = Organizer::where('slug', $oslug)->first();

        if (!$organizer) {
            return response()->json([
                'message' => 'Organizer not found'
            ], 404);
        }

        $event = $organizer->events()->where('slug', $eslug)->first();
        // echo $event;
        if (!$event) {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }

        return response()->json(new EventDetailResource($event), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function registration(Request $request, $oslug, $eslug)
    {
        $user = $this->findUser($request);

        if (!$user) {
            return response()->json([
                'message' => 'User not logged in'
            ], 401);
        }

        $existsRegister = Registration::where('ticket_id', $request->ticket_id)->where('attendee_id', $user->id)->first();

        if ($existsRegister) {
            return response()->json([
                'message' => 'User already registered'
            ], 401);
        }

        $organizer = Organizer::where('slug', $oslug)->first();
        $event = $organizer->events()->where('slug', $eslug)->first();

        $ticket = Ticket::find($request->ticket_id);
        $val = json_decode($ticket->special_validity);
        $available = true;

        if ($val) {
            if ($val->type == 'amount') {
                $cnt = Registration::where('ticket_id', $ticket->id)->count();
                if ($val->amount <= $cnt) {
                    $available = false;
                }
            } else if ($val->type == 'date') {
                $today = new \DateTime(date('Y-m-d'));
                $date = new \DateTime($val->date);

                if ($today >= $date) {
                    $available = false;
                }
            }
        }

        if ($available) {
            $registration = Registration::create([
                'attendee_id' => $user->id,
                'ticket_id' => $request->ticket_id
            ]);

            if ($request->session_ids) {
                foreach ($request->session_ids as $id) {
                    SessionRegistration::create([
                        'registration_id' => $registration->id,
                        'session_id' => $id
                    ]);
                }
            }

            return response()->json([
                'message' => 'Registration successful'
            ], 200);
        }

        return response()->json([
            'message' => 'Ticket is no longer available'
        ], 401);
    }

    public function list(Request $request)
    {
        $user = $this->findUser($request);

        return response()->json([
            'registrations' => RegistrationResource::collection($user->registrations)
        ], 200);
    }
}
