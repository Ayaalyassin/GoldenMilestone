@extends('voyager::master')

@section('content')
<form action="{{ route('mark_a1.store') }}" method="POST">
    @csrf
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Project</th>
                <th>Homework</th>
                <th>Write</th>
                <th>Final</th>
            </tr>
        </thead>
        <tbody id="rows_container">
            <tr>
                <td>
                    <input type="text" class="form-control" name="name[]" required>
                </td>
                <td>
                    <input type="text" class="form-control" name="phone_number[]" required>
                </td>
                <td>
                    <input type="number" class="form-control" name="project[]" required>
                </td>
                <td>
                    <input type="number" class="form-control" name="homework[]" required>
                </td>
                <td>
                    <input type="number" class="form-control" name="write[]" required>
                </td>
                <td>
                    <input type="number" class="form-control" name="final[]" required>
                </td>
            </tr>
        </tbody>
    </table>
    <button type="button" class="btn btn-primary" id="add_row">Add Row</button>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
    // JavaScript code to dynamically add rows
    document.getElementById('add_row').addEventListener('click', function () {
        var rowsContainer = document.getElementById('rows_container');
        var rowTemplate = document.querySelector('tbody tr').cloneNode(true);
        rowsContainer.appendChild(rowTemplate);
    });
</script>
@endsection
