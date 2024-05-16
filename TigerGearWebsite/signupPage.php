<?php


?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/auth.css">
    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="logo.png">

</head>

<body>
    <div id="response"></div>

    <div class="container">
        <div class="screen">
            <div class="screen__content">
                <form class="signup">
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input required id="fname" type="text" class="login__input" placeholder="First name">
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input required id="lname" type="text" class="login__input" placeholder="Last name">
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input required id="username" type="text" class="login__input" placeholder="Username">
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input required id="password" type="password" class="login__input" placeholder="Password">
                    </div>
                    <button type="button" id="signup" class="button login__submit">
                        <span class="button__text">Signup</span>
                        <i class="button__icon fas fa-chevron-right"></i>
                    </button>
                    <div class="register-signup">
                        <span>
                            Already registered ?
                            <a href="loginPage.php">Login</a>
                        </span>
                    </div>
                </form>
                <div class="social-login">
                    <h3>Welcome To Tiger Gear's Shop</h3>
                </div>
            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>
        </div>
    </div>



    <script type="text/javascript">
        $(document).ready(function() {
            $("#signup").on('click', function() {
                var username = $("#username").val(); // Get the value of the username input field
                var fname = $("#fname").val(); // Get the value of the fname input field
                var lname = $("#lname").val(); // Get the value of the lname input field
                var password = $("#password").val(); // Get the value of the password input field

                if (username.length < 3 || password.length < 3) {
                    return alert("Username and password should be longer than 3 characters");
                    // If the username or password is less than 3 characters, display an alert and stop the execution of the function
                }

                $.post({
                    url: 'auth/signup.php', // The URL to which the form data will be sent
                    method: 'POST', // The HTTP method used for the request
                    data: {
                        username: username,
                        password: password,
                        fname: fname,
                        lname: lname,
                    }, // The data to be sent in the request, including the username, password, fname, and lname
                    success: function(response) {
                        if (response.indexOf('Username Already Exists') >= 0) {
                            alert('User name already exists. Please try another username');
                            // If the response contains the message 'Username Already Exists', display an alert
                        }
                        if (response.indexOf('success') >= 0) {
                            window.location.href = './index.php';
                            // If the response contains the message 'success', redirect the user to the index.php page
                        } else {
                            alert("Something Went Wrong. Please try again.");
                            // If the response does not contain 'success', display an alert
                        }
                    },
                    dataType: 'text',
                    // The expected data type of the response
                });
            });
        });
    </script>
</body>

</html>