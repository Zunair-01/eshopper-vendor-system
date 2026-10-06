<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <form id="registration-form" action="{{ url('auth/register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}" required class="{{ $errors->has('name') ? 'error-input' : '' }}">
                @if($errors->has('name'))
                    <div class="error-message">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required class="{{ $errors->has('email') ? 'error-input' : '' }}">
                @if($errors->has('email'))
                    <div class="error-message">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="0343*******" value="{{ old('phone') }}" required class="{{ $errors->has('phone') ? 'error-input' : '' }}" oninput="formatPhone(this)">
                @if($errors->has('phone'))
                    <div class="error-message">{{ $errors->first('phone') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required class="{{ $errors->has('password') ? 'error-input' : '' }}">
                @if($errors->has('password'))
                    <div class="error-message">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="password_confirmation" placeholder="Confirm your password" required class="{{ $errors->has('password_confirmation') ? 'error-input' : '' }}">
                @if($errors->has('password_confirmation'))
                    <div class="error-message">{{ $errors->first('password_confirmation') }}</div>
                @endif
            </div>

            <button type="submit">Register</button>
        </form>
        <p class="login-prompt">Already have an account? <a href="{{ url('auth/login') }}">Login here</a></p>
    </div>
</body>
</html>

