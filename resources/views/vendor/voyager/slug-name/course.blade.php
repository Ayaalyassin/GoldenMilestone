@extends('voyager::master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Upload File</div>

                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
<head>
    <title>Upload PDF and Voice Files</title>
</head>
<body>
    <form action="{{ route('uploadCourse') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="course">Course:</label>
            <select class="form-control select2" id="course" name="course">
                <option value="A1">A1</option>
                <option value="A2">A2</option>
                <option value="A3">A3</option>
                <option value="B1">B1</option>
                <option value="B2">B2</option>
                <option value="B3">B3</option>
                <option value="C1">C1</option>
                <option value="C2">C2</option>
                <option value="C3">C3</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pdf_file">Select PDF File:</label>
            <input type="file" id="pdf_file" name="pdf_file" accept=".pdf">
        </div>

        <div class="form-group">
            <label for="voice_file">Select Voice File:</label>
            <input type="file" id="voice_file" name="voice_file" accept="audio/*">
        </div>

        <button  type="submit" class="btn btn-primary">Upload Files</button>
    </form>
</body>

@endsection
