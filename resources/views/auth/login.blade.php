<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="{{ url('auth/login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required class="{{ $errors->has('email') ? 'error-input' : '' }}" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <div class="error-message">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required class="{{ $errors->has('password') ? 'error-input' : '' }}">
                @if($errors->has('password'))
                    <div class="error-message">{{ $errors->first('password') }}</div>
                @endif
            </div>
            <p class="forgot-password"><a href="{{ url('auth/forgot-password') }}">Forgot Password?</a></p>
            <button type="submit">Login</button>
        </form>
        <p class="login-prompt">Don't have an account? <a href="{{ url('auth/register') }}">Register here</a></p>
    </div>
</body>
</html>
