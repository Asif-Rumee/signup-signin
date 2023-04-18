<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Registration</title>
</head>
<body>
    <div class="container w-50 mx-auto mt-5 border p-4">
        <h2 class="d-flex justify-content-center">Sign Up</h2>
        <form action="{{route('register')}}" method="POST">
            @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif
            @if(Session::has('fail'))
                <div class="alert alert-danger">{{Session::get('fail')}}</div>
            @endif
            @csrf
            <div class="form-group">
                <label for="name">User Name:</label>
                <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="User Name">
                <span class="text-danger">@error('name') {{$message}} @enderror</span>
            </div>
            <div class="form-group">
                <label for="emailOrMobile">Email or Mobile Number:</label>
                <input type="text" class="form-control" id="emailOrMobile" name="emailOrMobile" value="{{old('emailOrMobile')}}" placeholder="Email / Mobile Number">
                <span class="text-danger">@error('emailOrMobile') {{$message}} @enderror</span>
                <span id="email_error" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" value="" placeholder="Password">
                <span class="text-danger">@error('password') {{$message}} @enderror</span>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" value="" placeholder="Confirm Password">
                <span id="password_error" class="text-danger"></span>
            </div>
            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mt-3">Sign Up</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
</body>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#emailOrMobile').blur(function() { // bind blur event to email input field
                let emailOrMobile = $(this).val(); // get the value of the email input field
                $.ajax({
                    type: 'POST',
                    url: 'check-email', // the Laravel route that checks if the email exists
                    data: { emailOrMobile: emailOrMobile },
                    success: function(response) {
                        if (response == 'exists') {
                            // display an error message
                            $('#email_error').html('This email or mobile number is already registered.');
                            $('#email_error').show();
                        } else {
                            $('#email_error').hide();
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            $('#confirmPassword').blur(function() { 
                function checkPasswords() {
                    var password = $('#password').val();
                    var confirmPassword = $('#confirmPassword').val();
                    if(password !== confirmPassword){
                        $('#password_error').html('The passwords do not match.');
                        $('#password_error').show();
                        $('button').prop('disabled', true);
                    }else if(password == confirmPassword){
                        $('#password_error').hide();
                        $('button').prop('disabled', false);
                    }
                }
                checkPasswords();
            });
        });
    </script>
</html>