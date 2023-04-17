<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <div class="container w-50 mx-auto mt-5 border p-4">
        <h2 class="d-flex justify-content-center">Sign In</h2>
        <form action="{{route('login')}}" method="POST">
            @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif
            @if(Session::has('fail'))
                <div class="alert alert-danger">{{Session::get('fail')}}</div>
            @endif
            @csrf
            <div class="form-group">
                <label for="emailOrMobile">Email or Mobile Number:</label>
                <input type="text" class="form-control" name="emailOrMobile" value="{{old('emailOrMobile')}}" placeholder="Email / Mobile Number">
                <span class="text-danger">@error('emailOrMobile') {{$message}} @enderror</span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" value="" placeholder="Password">
                <span class="text-danger">@error('password') {{$message}} @enderror</span>
            </div>
            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mt-3">Sign In</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>