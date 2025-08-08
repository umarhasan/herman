<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
                    <h2>CREATE YOUR ACCOUNT</h2>
                    <p>Enter details to register a new account</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-row">
                        <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
                        @error('name')<span class="text-danger d-block">{{ $message }}</span>@enderror
                    </div>

                    <!-- Email -->
                    <div class="form-row">
                        <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                        @error('email')<span class="text-danger d-block">{{ $message }}</span>@enderror
                    </div>

                    <!-- Password -->
                    <div class="form-row form-btn">
                        <input type="password" name="password" id="password" placeholder="Password" required>
                        <span class="toggle-password" onclick="togglePassword()">👁</span>
                        @error('password')<span class="text-danger d-block">{{ $message }}</span>@enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-row">
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                        @error('password_confirmation')<span class="text-danger d-block">{{ $message }}</span>@enderror
                    </div>
					<!-- Date of Birth -->
                    <div class="form-row position-relative">
                        <input type="date" name="date_of_birth" id="date_of_birth"
                            value="{{ old('date_of_birth') }}"
                            class="form-control" required style="padding-right: 40px;">
                        @error('date_of_birth')
                            <span class="text-danger d-block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Actions -->
                    <button type="submit" class="signup-btn">Register</button>

                    <div class="text mt-3">
                        <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
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
