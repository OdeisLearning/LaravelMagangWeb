<!DOCTYPE html>
<html>
<head>
    <title>data App</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('mahasiswa') }}">data Alert</a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('mahasiswa') }}">View All mahasiswa</a></li>
        <li><a href="{{ URL::to('mahasiswa/create') }}">Create a data</a>
    </ul>
</nav>

<h1>All the mahasiswa</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>User_Id</td>
            <td>Kelas_Id</td>
            <td>NIM</td>
            <td>Nama</td>
            <td>Tempat Lahir</td>
            <td>Tanggal Lahir</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>
    @foreach($mahasiswa as $key => $value)
        <tr>
            <td>{{ $value->user_id }}</td>
            <td>{{ $value->kelas_id }}</td>
            <td>{{ $value->nim }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->tempat_lahir }}</td>
            <td>{{ $value->tanggal_lahir }}</td>

            <!-- we will also add show, edit, and delete buttons -->
            <td>

                <!-- delete the data (uses the destroy method DESTROY /mahasiswa/{id} -->
                <!-- we will add this later since its a little more complicated than the other two buttons -->

                <!-- show the data (uses the show method found at GET /mahasiswa/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('mahasiswa/' . $value->id) }}">Show this data</a>

                <!-- edit this data (uses the edit method found at GET /mahasiswa/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('mahasiswa/' . $value->id . '/edit') }}">Edit this data</a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</div>
</body>
</html>