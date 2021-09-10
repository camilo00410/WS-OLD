<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Support\Facades\Auth;
use App\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Auth::user()->events()->orderBy('date', 'asc')->get();

        return view('events.index', [
            'events' => $events
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only([
            'slug', 'name', 'date'
        ]);

        $valRequired = Validator::make($input, [
            'slug' => 'required',
            'name' => 'required',
            'date' => 'required'
        ]);

        if ($valRequired->fails()) {
            return back()->with([
                'messageType' => 'danger',
                'message' => 'All fields required'
            ]);
        }

        $val = Validator::make($input, [
            'slug' => 'required'
        ]);

        preg_match("/[^a-z0-9\-]/", $input['slug'], $match);

        if ($val->fails() || count($match) > 0) {
            return back()->with([
                'messageType' => 'danger',
                'message' => 'Slug must not be empty and only contain a-z, 0-9 and \'-\''
            ]);
        }

        $valData = Validator::make($input, [
            'date' => 'date'
        ]);

        if ($valData->fails()) {
            return back()->with([
                'messageType' => 'danger',
                'message' => 'date format is wrong'
            ]);
        }

        $existsSlug = Auth::user()->events()->where('slug', $input['slug'])->first();

        if ($existsSlug) {
            return back()->with([
                'messageType' => 'danger',
                'message' => 'Slug is already used'
            ]);
        }

        $event = Auth::user()->events()->save(new Event($input));

        return redirect()->route('event.show', $event->id)->with([
            'messageType' => 'success',
            'message' => 'Event successfully created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('events.detail', [
            'event' => $event
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('events.edit', [
            'event' => $event
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $input = $request->only([
            'slug', 'name', 'date'
        ]);

        $valRequired = Validator::make($input, [
            'slug' => 'required',
            'name' => 'required',
            'date' => 'required'
        ]);

        if ($valRequired->fails()) {
            return back()->with([
                'messageType' => 'danger',
                'message' => 'All fields required'
            ]);
        }

        $val = Validator::make($input, [
            'slug' => 'required'
        ]);

        preg_match("/[^a-z0-9\-]/", $input['slug'], $match);

        if ($val->fails() || count($match) > 0) {
            return back()->with([
                'messageType' => 'danger',
                'message' => 'Slug must not be empty and only contain a-z, 0-9 and \'-\''
            ]);
        }

        $valData = Validator::make($input, [
            'date' => 'date'
        ]);

        if ($valData->fails()) {
            return back()->with([
                'messageType' => 'danger',
                'message' => 'date format is wrong'
            ]);
        }

        $existsSlug = Auth::user()->events()->where('slug', $input['slug'])->first();

        if ($event->slug != $input['slug'] && $existsSlug) {
            return back()->with([
                'messageType' => 'danger',
                'message' => 'Slug is already used'
            ]);
        }

        $event->update($input);

        return redirect()->route('event.show', $event->id)->with([
            'messageType' => 'success',
            'message' => 'Event successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }

    public function report(Event $event)
    {
        $sessions = [];

        foreach ($event->rooms as $room) {
            foreach ($room->sessions as $session) {
                $session->capacity = $room->capacity;
                $session->attendee = $session->registrations()->count();
                $sessions[] = $session;
            }
        }

        return view('reports.index', [
            'event' => $event,
            'sessions' => $sessions
        ]);
    }
}
