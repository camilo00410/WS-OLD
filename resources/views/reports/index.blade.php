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
            <div class="border-bottom mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">{{ $event->name }}</h1>
                </div>
                <span class="h6">{{ $event->date }}</span>
            </div>

            <div class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Room Capacity</h2>
                </div>
            </div>

            <!-- TODO create chart here -->
            <canvas id="graph"></canvas>
        </main>
    </div>
</div>

<script>
    const c = document.getElementById('graph');
    const ctx = c.getContext('2d');
    const sessions = @json($sessions);
    const attendees = [];
    const capacities = [];
    const backgroundColor = [];

    sessions.forEach(x => {
        attendees.push(x.attendee);
        capacities.push(x.capacity);
        if (x.capacity < x.attendee) {
            backgroundColor.push('#fa555f');
        } else {
            backgroundColor.push('#28c195');
        }
    });
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: sessions.map(x => x.title),
            datasets: [
                {
                    label: 'Attendees',
                    data: attendees,
                    backgroundColor
                },
                {
                    label: 'Capacity',
                    data: capacities,
                    backgroundColor: '#007bfd'
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0
                    }
                }],
                xAxes: [{
                    ticks: {
                        minRotation: 45
                    }
                }]
            }
        }
    });
</script>
@endsection