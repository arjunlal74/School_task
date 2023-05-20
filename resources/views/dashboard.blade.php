<!DOCTYPE html>
<html>
<head>
    <title>Schools</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        .table-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Schools</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('selected.school')}}">Selected Schools</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('logout')}}">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div id="app">
        <div class="container table-container">
            <form action="{{route('select.school')}}" method="POST">
                @csrf
                @if (Session::has('error'))
                <div class="alert alert-danger" role="alert">
                {{session('error')}}
                </div>
                @endif
                @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                {{session('success')}}
                </div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>School</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through schools data -->
                        @foreach ($schools as $school)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$school->name}}</td>
                                <td>{{$school->address}}</td>
                                <td>{{$school->city}}</td>
                                <td><input type="checkbox" name="action[]" value="{{$school->id}}"></td>
                            </tr>
                        @endforeach

                        <!-- End loop -->
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
