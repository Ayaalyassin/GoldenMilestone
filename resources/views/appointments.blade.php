@extends('voyager::master')

@section('content')

<h1>Create Appointment</h1>

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="date_appointment">Date:</label>
            <input type="date" class="form-control" name="date_appointment" required>
        </div>

        <div class="form-group">
            <label for="time_appointment">Time:</label>
            <input type="time" class="form-control" name="time_appointment" required>
        </div>

        <div class="form-group">
            <label for="place_appointment">Place:</label>
            <input type="text" class="form-control" name="place_appointment" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Appointment</button>
    </form>
@endsection
