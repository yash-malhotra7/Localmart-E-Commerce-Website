<?php
// Include the init.php script to initialize the database connection
include 'init.php';

// Check if email is set in POST request
if(isset($_POST['email'])) {
    // Sanitize the email input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Prepare SQL statement to check if email exists in the database
    $query = "SELECT COUNT(*) AS count FROM users WHERE email = ?";
    $statement = $mysqli->prepare($query);
    $statement->bind_param("s", $email);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();

    // Check if email exists
    if($row['count'] > 0) {
        echo 'exists'; // Email already exists
    } else {
        echo 'available'; // Email is available
    }

    // Close prepared statement and database connection
    $statement->close();
    $mysqli->close();
} else {
    // If email is not set in POST request, return error
    echo 'error';
}
?>
