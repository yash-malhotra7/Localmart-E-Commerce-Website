<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LocalMart - Home</title>
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
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1); /* subtle shadow */
            width: 340px;
        }
        .logo {
            display: block;
            margin: 0 auto 2rem auto; /* center logo */
            width: 180px; /* logo width */
            height: auto; /* maintain aspect ratio */
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-control {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="images/logo-PNG.png" alt="LocalMart Logo" class="logo">
        <h2>Login</h2>
        <form action="login_process.php" method="post">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <div class="text-center mt-3">
                <p>Don't have an account? <a href="signup.php">Create one</a></p>
            </div>
        </form>
    </div>
    <!-- Bootstrap JS and jQuery (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
