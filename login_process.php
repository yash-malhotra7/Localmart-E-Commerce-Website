<?php

// Include the init.php script to initialize the database connection
include 'init.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare an SQL statement to retrieve user data based on the provided email
    $query = "SELECT * FROM users WHERE email = ?";
    $statement = $mysqli->prepare($query);

    // Bind parameters to the prepared statement
    $statement->bind_param("s", $email);

    // Execute the prepared statement
    $statement->execute();

    // Get the result
    $result = $statement->get_result();

    // Check if a user with the provided email exists
    if ($result->num_rows == 1) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables and redirect based on user role
            session_start();
            $_SESSION['userid'] = $user['userid'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on user role
            if ($user['role'] === 'Seller') {
                header("Location: seller_home.php"); // Redirect to seller home page
            } else if ($user['role'] === 'Buyer') {
                header("Location: buyer_home.php"); // Redirect to buyer home page
            }
            exit();
        } else {
            // Password is incorrect, set error message session variable
            session_start();
            $_SESSION['error_message'] = "Invalid email or password.";
            header("Location: index.php"); // Redirect to index.php page
            exit();
        }
    } else {
        // No user found with the provided email, set error message session variable
        session_start();
        $_SESSION['error_message'] = "Invalid email or password.";
        header("Location: index.php"); // Redirect to index.php page
        exit();
    }

    // Close statement
    $statement->close();
}

// Close database connection
$mysqli->close();

?>
