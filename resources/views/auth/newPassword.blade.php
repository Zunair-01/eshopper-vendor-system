<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/auth/new.css') }}">
</head>
<body>
    <div class="container">
        <h1>Reset Password</h1>
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your new password" required>
                @if($errors->has('password'))
                    <div class="error-message" style="color: red">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="password_confirmation" placeholder="Confirm your new password" required>
                @if($errors->has('password'))
                    <div class="error-message" style="color: red">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <button type="submit">Update Password</button>
        </form>
       
    </div>
</body>
</html>
