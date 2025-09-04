<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('Backend/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .content h3 {
            text-align: center;
            color: white;
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -1px;
            margin: 0;
        }
        .tab-buttons {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .tab-buttons button {
            padding: 10px 20px;
            border: none;
            background: #ddd;
            margin: 0 5px;
            cursor: pointer;
            border-radius: 5px;
        }
        .tab-buttons button.active {
            background: #007bff;
            color: #fff;
        }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .form-container1 {
            background: #CC992E;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 110vh;
            font-family: 'Montserrat';
        }
        label {
            padding: 15px;
            font-size: 14px;
            font-weight: 600;
            color: #f7f5f5;
            margin-bottom: 6px;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <section class="signupsec">
        <div class="form-container1">

            <div class="container">
                <div class="content">
                    <h3>CREATE YOUR ACCOUNT</h3>
                    <p>Enter details to register a new account</p>
                </div>

                <!-- Tabs -->
                <div class="tab-buttons">
                    <button type="button" class="tab-btn active" data-tab="student">Student</button>
                    <button type="button" class="tab-btn" data-tab="teacher">Teacher</button>
                    <button type="button" class="tab-btn" data-tab="user">User</button>
                </div>

                <!-- Student Form -->
                <div id="student" class="tab-content active">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input type="hidden" name="role" value="student">
                        <label>Full Name</label>
                        <div class="form-row">
                            <input type="text" name="name" placeholder="Full Name" required>
                        </div>
                        <label>Email Address</label>
                        <div class="form-row">
                            <input type="email" name="email" placeholder="Email Address" required>
                        </div>
                        <label>Date Of Birth</label>
                        <div class="form-row">
                            <input type="date" name="date_of_birth" placeholder="Date of Birth">
                        </div>
                        <label>Parent Email</label>
                        <div class="form-row">
                            <input type="email" name="parent_email" placeholder="Parent Email" required>
                        </div>
                        <label>Parent Phone Number</label>
                        <div class="form-row">
                            <input type="text" name="parent_phone" placeholder="Parent Phone Number">
                        </div>
                        <label>Password</label>
                        <div class="form-row form-btn">
                            <input type="password" name="password" id="password_student" placeholder="Password" required>
                            <span class="toggle-password" onclick="togglePassword('password_student')">👁</span>
                        </div>
                        <label>Confirm Password</label>
                        <div class="form-row">
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                        </div>
                        <button type="submit" class="signup-btn">Register as Student</button>
                    </form>
                </div>

                <!-- Teacher Form -->
                <div id="teacher" class="tab-content">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input type="hidden" name="role" value="teacher">
                        <label>Full Name</label>
                        <div class="form-row">
                            <input type="text" name="name" placeholder="Full Name" required>
                        </div>

                        <label>Email</label>
                        <div class="form-row">
                            <input type="email" name="email" placeholder="Email Address" required>
                        </div>

                        <label>Date Of Birth</label>
                        <div class="form-row">
                            <input type="date" name="date_of_birth" placeholder="Date of Birth">
                        </div>

                        <label>Experience</label>
                        <div class="form-row">
                            <input type="text" name="experience" placeholder="Experience">
                        </div>

                        <label>Description</label>
                        <div class="form-row">
                            <input type="text" name="description" placeholder="Description"></input>
                        </div>

                        <label>Password</label>
                        <div class="form-row form-btn">
                            <input type="password" name="password" id="password_teacher" placeholder="Password" required>
                            <span class="toggle-password" onclick="togglePassword('password_teacher')">👁</span>
                        </div>

                        <label>Confirm Password</label>
                        <div class="form-row">
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                        </div>

                        <button type="submit" class="signup-btn">Register as Teacher</button>
                    </form>
                </div>

                <!-- User Form -->
                <div id="user" class="tab-content">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input type="hidden" name="role" value="user">
                        <label>Name</label>
                        <div class="form-row">
                            <input type="text" name="name" placeholder="Full Name" required>
                        </div>

                        <label>Email</label>
                        <div class="form-row">
                            <input type="email" name="email" placeholder="Email Address" required>
                        </div>

                        <label>Date Of Birth</label>
                        <div class="form-row">
                            <input type="date" name="date_of_birth" placeholder="Date of Birth">
                        </div>

                        <label>Password</label>
                        <div class="form-row form-btn">
                            <input type="password" name="password" id="password_user" placeholder="Password" required>
                            <span class="toggle-password" onclick="togglePassword('password_user')">👁</span>
                        </div>

                        <label>Confirm</label>
                        <div class="form-row">
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                        </div>

                        <button type="submit" class="signup-btn">Register as User</button>
                    </form>
                </div>

                <div class="text mt-3">
                    <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Toggle Password
        function togglePassword(id) {
            var passwordField = document.getElementById(id);
            var type = passwordField.getAttribute("type") === "password" ? "text" : "password";
            passwordField.setAttribute("type", type);
        }

        // Tabs JS
        const buttons = document.querySelectorAll(".tab-btn");
        const contents = document.querySelectorAll(".tab-content");

        buttons.forEach(btn => {
            btn.addEventListener("click", () => {
                buttons.forEach(b => b.classList.remove("active"));
                contents.forEach(c => c.classList.remove("active"));

                btn.classList.add("active");
                document.getElementById(btn.dataset.tab).classList.add("active");
            });
        });
    </script>
</body>
</html>
