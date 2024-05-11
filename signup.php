<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LocalMart - Signup</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: url('images/background.jpeg') repeat center center fixed;;
            height: 100vh; /* full height of the viewport */
            display: flex;
            align-items: center; /* aligns vertically */
            justify-content: center; /* aligns horizontally */
        }
        .signup-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1); /* subtle shadow */
            width: 360px; /* adjust as per content */
        }
        .logo {
            display: block;
            margin: 0 auto 1.5rem auto; /* center logo */
            width: 180px; /* logo width */
            height: auto; /* maintain aspect ratio */
        }
        .signup-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-control {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <img src="images/logo-PNG.png" alt="LocalMart Logo" class="logo">
        <h2>Signup</h2>
        <form action="signup_process.php" method="post" id="signupForm"> <!-- Added id for the form -->
            <div class="form-group">
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
                <small id="emailError" class="form-text text-danger"></small> <!-- Error message for email -->
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <select class="form-control" id="role" name="role" required>
                    <option value="Seller">Seller</option>
                    <option value="Buyer">Buyer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block" id="signupBtn">Signup</button> <!-- Added id for the signup button -->
        </form>
        <div class="text-center mt-3">
            <p>Already have an account? <a href="index.php">Login here</a></p>
        </div>
    </div>
    <!-- Bootstrap JS and jQuery (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Function to check if the email is already in use
        $('#email').on('blur', function() {
            var email = $(this).val();
            $.ajax({
                url: 'check_email.php',
                type: 'POST',
                data: {email: email},
                success: function(response) {
                    if (response === 'exists') {
                        $('#emailError').text('Email is already in use');
                        $('#signupBtn').prop('disabled', true); // Disable signup button if email exists
                    } else {
                        $('#emailError').text('');
                        $('#signupBtn').prop('disabled', false); // Enable signup button if email doesn't exist
                    }
                }
            });
        });
    </script>
</body>
</html>
