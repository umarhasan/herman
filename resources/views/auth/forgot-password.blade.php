<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="{{ asset('Backend/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <section class="signupsec">
        <div class="form-container">
            <div class="container">
                <div class="div-logo">
                    <a href="{{ url('/') }}" class="logo1">Tefillin Rebbe</a>
                </div>
                <div class="content">
                    <h2>Forgot Password?</h2>
                    <p>Enter your email address and we will send you a link to reset your password.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-row">
                        <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                        @error('email')<span class="text-danger d-block">{{ $message }}</span>@enderror
                    </div>

                    <button type="submit" class="signup-btn">Send Password Reset Link</button>

                    <div class="text mt-3">
                        <p><a href="{{ route('login') }}">Back to Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>
