<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="{{ asset('css/auth/forgot.css') }}">
</head>
<body>
    <div class="container">
        <h1>Forgot Password</h1>

        <!-- Check for any session status messages -->
        @if (session('status'))
            <div class="alert success">{{ session('status') }}</div>
        @endif

        <!-- Check for validation errors -->
        @if ($errors->any())
            <div class="alert danger"> <!-- Use 'danger' class for error messages -->
                <p>{{ $errors->first() }}</p> <!-- Display the first error message -->

            </div>
        @endif

        <form action="{{ url('auth/reset-email') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <button type="submit">Send Reset Link</button>
        </form>
        <p class="login-prompt">Remembered your password? <a href="{{ url('auth/login') }}">Login here</a></p> <!-- Link to login page -->
    </div>
</body>
</html>
