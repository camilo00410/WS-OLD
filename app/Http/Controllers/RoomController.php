<?php

namespace App\Http\Controllers;

use Validator;
use App\Event;
use App\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
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
        return view('rooms.create', [
            'event' => $event
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    
    // ROOM
    public function store(Request $request, Event $event)
    {
        $input = $request->only([
            'name', 'channel_id', 'capacity'
        ]);

        $val = Validator::make($input, [
            'name' => 'required',
            'channel_id' => 'required',
            'capacity' => 'required'
        ]);

        if ($val->fails()) {
            return back()->with([
                'messageType' => 'danger',
                'message' => 'all fields required'
            ]);
        }

        Room::create($input);

        return redirect()->route('event.show', $event->id)->with([
            'messageType' => 'success',
            'message' => 'Room successfully created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        //
    }
}
