@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="{{ route('event.index') }}">Manage Events</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>{{ $event->name }}</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('event.show', $event->id) }}">Overview</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Reports</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item"><a class="nav-link" href="{{ route('event.report', $event->id) }}">Room capacity</a></li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="border-bottom mb-3 pt-3 pb-2 event-title">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">{{ $event->name }}</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="{{ route('event.edit', $event->id) }}" class="btn btn-sm btn-outline-secondary">Edit event</a>
                        </div>
                    </div>
                </div>
                <span class="h6">{{ $event->date }}</span>
            </div>

            <!-- Tickets -->
            <div id="tickets" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Tickets</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="{{ route('ticket.create', $event->id) }}" class="btn btn-sm btn-outline-secondary">
                                Create new ticket
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row tickets">
                @foreach ($event->tickets as $ticket)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $ticket->name }}</h5>
                                <p class="card-text">{{ $ticket->cost }}.-</p>
                                <p class="card-text">
                                    <?php
                                    $val = json_decode($ticket->special_validity);

                                    if ($val) {
                                        if ($val->type == 'amount') {
                                            echo $val->amount . ' tickets available';
                                        } else if ($val->type == 'date') {
                                            $date = date_format(new \DateTime($val->date), 'F d, Y');
                                            echo 'Available until ' . $date;
                                        }
                                    } else {
                                        echo 'NULL';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{--<div class="col-md-4">--}}
                    {{--<div class="card mb-4 shadow-sm">--}}
                        {{--<div class="card-body">--}}
                            {{--<h5 class="card-title">Early Bird</h5>--}}
                            {{--<p class="card-text">120.-</p>--}}
                            {{--<p class="card-text">Available until June 1, 2019</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-4">--}}
                    {{--<div class="card mb-4 shadow-sm">--}}
                        {{--<div class="card-body">--}}
                            {{--<h5 class="card-title">VIP</h5>--}}
                            {{--<p class="card-text">400.-</p>--}}
                            {{--<p class="card-text">100 tickets available</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>

            <!-- Sessions -->
            <div id="sessions" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Sessions</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="{{ route('session.create', $event->id) }}" class="btn btn-sm btn-outline-secondary">
                                Create new session
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive sessions">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Time</th>
                        <th>Type</th>
                        <th class="w-100">Title</th>
                        <th>Speaker</th>
                        <th>Channel</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($event->rooms as $room)
                        @foreach ($room->sessions as $session)
                            <tr>
                                <td class="text-nowrap">{{ date_format(new \DateTime($session->start), 'H:i') }} - {{ date_format(new \DateTime($session->end), 'H:i') }}</td>
                                <td>{{ $session->type }}</td>
                                <td><a href="{{ route('session.edit', [$event->id, $session->id]) }}">{{ $session->title }}</a></td>
                                <td class="text-nowrap">{{ $session->speaker }}</td>
                                <td class="text-nowrap">{{ $room->channel->name }} / {{ $room->name }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    {{--<tr>--}}
                        {{--<td class="text-nowrap">08:30 - 10:00</td>--}}
                        {{--<td>Talk</td>--}}
                        {{--<td><a href="sessions/edit.html">Keynote</a></td>--}}
                        {{--<td class="text-nowrap">An important person</td>--}}
                        {{--<td class="text-nowrap">Main / Room A</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td class="text-nowrap">10:15 - 11:00</td>--}}
                        {{--<td>Talk</td>--}}
                        {{--<td><a href="sessions/edit.html">What's new in X?</a></td>--}}
                        {{--<td class="text-nowrap">Another person</td>--}}
                        {{--<td class="text-nowrap">Main / Room A</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td class="text-nowrap">10:15 - 11:00</td>--}}
                        {{--<td>Workshop</td>--}}
                        {{--<td><a href="sessions/edit.html">Hands-on with Y</a></td>--}}
                        {{--<td class="text-nowrap">Another person</td>--}}
                        {{--<td class="text-nowrap">Side / Room C</td>--}}
                    {{--</tr>--}}
                    </tbody>
                </table>
            </div>

            <!-- Channels -->
            <div id="channels" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Channels</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="{{ route('channel.create', $event->id) }}" class="btn btn-sm btn-outline-secondary">
                                Create new channel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row channels">
                @foreach ($event->channels as $channel)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $channel->name }}</h5>
                                <p class="card-text">{{ $channel->sessions()->count() }} sessions, {{ $channel->rooms()->count() }} room</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{--<div class="col-md-4">--}}
                    {{--<div class="card mb-4 shadow-sm">--}}
                        {{--<div class="card-body">--}}
                            {{--<h5 class="card-title">Side</h5>--}}
                            {{--<p class="card-text">15 sessions, 2 rooms</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>

            <!-- Rooms -->
            <div id="rooms" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Rooms</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="{{ route('room.create', $event->id) }}" class="btn btn-sm btn-outline-secondary">
                                Create new room
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive rooms">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Capacity</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($event->rooms as $room)
                        <tr>
                            <td>{{ $room->name }}</td>
                            <td>{{ number_format($room->capacity) }}</td>
                        </tr>
                    @endforeach
                    {{--<tr>--}}
                        {{--<td>Room A</td>--}}
                        {{--<td>1,000</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Room B</td>--}}
                        {{--<td>100</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Room C</td>--}}
                        {{--<td>100</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Room D</td>--}}
                        {{--<td>250</td>--}}
                    {{--</tr>--}}
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>
@endsection