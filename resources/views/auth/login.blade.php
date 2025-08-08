<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                    <h2>SIGN IN TO ACCOUNT</h2>
                    <p>Enter Your Email & Password to Login</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-row">
                        <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                        @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-row form-btn">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <span class="toggle-password" onclick="togglePassword()">👁</span>
                        @error('password')<span class="text-danger d-block">{{ $message }}</span>@enderror
                    </div>

                    <div class="extra-options d-flex justify-content-between align-items-center">
                        <label class="m-0">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="signup-btn">Sign In</button>

                    <div class="text mt-3">
                        @if (Route::has('register'))
                            <p>Don't Have an Account? <a href="{{ route('register') }}">Create Account</a></p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var type = passwordField.getAttribute("type") === "password" ? "text" : "password";
            passwordField.setAttribute("type", type);
        }
    </script>
</body>

</html>

