<?php

namespace App\Http\Controllers;

use Validator;
use App\Event;
use App\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
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
        return view('tickets.create', [
            'event' => $event
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Event $event)
    {
        $input = $request->only([
            'cost', 'name', 'capacity', 'special_validity', 'date', 'valid_until', 'amount'
        ]);

        $args = [
            'name' => 'required',
            'cost' => 'required'
        ];

        $ticketArgs = [
            'name' => $input['name'],
            'cost' => $input['cost']
        ];

        if ($input['special_validity'] == 'amount') {
            $args['amount'] = 'required';
            $ticketArgs['special_validity'] = json_encode(['type' => 'amount', 'amount' => $input['amount']]);
        }

        if ($input['special_validity'] == 'date') {
            $args['valid_until'] = 'required';
            $ticketArgs['special_validity'] = json_encode(['type' => 'date', 'date' => $input['valid_until']]);
        }

        $val = Validator::make($input, $args);

        if ($val->fails()) {
            return back()->with([
                'messageType' => 'danger',
                'message' => 'name and cost field are required, also any field that is relate'
            ]);
        }

        $valDate = Validator::make($input, [
            'valid_until' => 'date|date_format:Y-m-d H:i'
        ]);

        if ($valDate->fails()) {
            return back()->with([
                'messageType' => 'danger',
                'message' => 'Date format is wrong'
            ]);
        }

        $event->tickets()->save(new Ticket($ticketArgs));

        return redirect()->route('event.show', $event->id)->with([
            'messageType' => 'success',
            'message' => 'Ticket successfully created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
