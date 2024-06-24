@extends('voyager::master')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ url('/new-table') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="table_name">Table Name:</label>
        <input type="text" class="form-control" name="table_name" id="table_name" required>
    </div>
    <div class="form-group">
        <label for="column_name">Column Names:</label>
        <div id="column_container">
            <input type="text" class="form-control" name="column_name[]" required>
        </div>
        <button type="button" class="btn btn-primary" id="add_column">Add Column</button>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
    document.getElementById('add_column').addEventListener('click', function() {
        var container = document.getElementById('column_container');
        var input = document.createElement('input');
        input.type = 'text';
        input.name = 'column_name[]';
        input.className = 'form-control';
        input.required = true;
        container.insertBefore(input, container.firstChild);
    });
</script>
@endsection
