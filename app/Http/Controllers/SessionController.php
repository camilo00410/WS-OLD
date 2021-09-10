<?php

namespace App\Http\Controllers;

use App\Room;
use Validator;
use App\Event;
use App\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Event $event)
    {
        return view('sessions.create', [
            'event' => $event
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // SESSION 
    public function store(Request $request, Event $event)
    {
        $input = $request->only([
            'start', 'end', 'description', 'type', 'title', 'speaker', 'cost', 'room_id'
        ]);

        $val = Validator::make($input, [
            'type' => 'required',
            'title' => 'required',
            'speaker' => 'required',
            'room_id' => 'required',
            'start' => 'required',
            'end' => 'required',
            'description' => 'required'
        ]);

        if ($val->fails()) {
            return back()->with([
                'messageType' => 'danger',
                'message' => 'all fields, except cost, required'
            ]);
        }

        $room = Room::find($input['room_id']);

        $currentSTime = date_format(new \DateTime($input['start']), 'H:i');
        $currentETime = date_format(new \DateTime($input['end']), 'H:i');
        $existsRoom = false;

        foreach ($room->sessions as $session) {
            $sTime = date_format(new \DateTime($session->start), 'H:i');
            $eTime = date_format(new \DateTime($session->end), 'H:i');

            if (($currentSTime >= $sTime && $currentSTime <= $eTime) || ($currentETime >= $sTime && $currentETime <= $eTime)) {
                $existsRoom = true;
            }
        }

        if ($existsRoom) {
            return back()->with([
                'messageType' => 'danger',
                'message' => 'Room already booked during this time'
            ]);
        }

        if ($input['type'] == 'talk' && $input['cost'] == 0) unset($input['cost']);

        Session::create($input);

        return redirect()->route('event.show', $event->id)->with([
            'messageType' => 'success',
            'message' => 'Session successfully created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function show(Session $session)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event, Session $session)
    {
        return view('sessions.edit', [
            'session' => $session,
            'event' => $event
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    // SESSION
    public function update(Request $request, Event $event, Session $session)
    {
        $input = $request->only([
            'start', 'end', 'description', 'type', 'title', 'speaker', 'cost', 'room_id'
        ]);

        $val = Validator::make($input, [
            'type' => 'required',
            'title' => 'required',
            'speaker' => 'required',
            'room_id' => 'required',
            'start' => 'required',
            'end' => 'required',
            'description' => 'required'
        ]);

        if ($val->fails()) {
            return back()->with([
                'messageType' => 'danger',
                'message' => 'all fields, except cost, required'
            ]);
        }

        $room = Room::find($input['room_id']);
        $sessions = $room->sessions()->where('id', '<>', $session->id)->get();

        $currentSTime = date_format(new \DateTime($input['start']), 'H:i');
        $currentETime = date_format(new \DateTime($input['end']), 'H:i');
        $existsRoom = false;

        foreach ($sessions as $item) {
            $sTime = date_format(new \DateTime($item->start), 'H:i');
            $eTime = date_format(new \DateTime($item->end), 'H:i');

            if (($currentSTime >= $sTime && $currentSTime <= $eTime) || ($currentETime >= $sTime && $currentETime <= $eTime)) {
                $existsRoom = true;
            }
        }

        if ($existsRoom) {
            return back()->with([
                'messageType' => 'danger',
                'message' => 'Room already booked during this time'
            ]);
        }

        if ($input['type'] == 'talk' && $input['cost'] == 0) unset($input['cost']);

        $session->update($input);

        return redirect()->route('event.show', $event->id)->with([
            'messageType' => 'success',
            'message' => 'Session successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        //
    }
}
