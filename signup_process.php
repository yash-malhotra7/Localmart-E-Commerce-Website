<?php

// Include the init.php script to initialize the database connection
include 'init.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an SQL statement to insert user data into the database
    $query = "INSERT INTO users (firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?)";
    $statement = $mysqli->prepare($query);

    // Bind parameters to the prepared statement
    $statement->bind_param("sssss", $firstname, $lastname, $email, $hashed_password, $role);

    // Execute the prepared statement
    if ($statement->execute()) {
        // Signup successful, create wishlist table for the buyer
        $buyer_id = $statement->insert_id; // Retrieve the ID of the newly inserted buyer

        // Prepare SQL statement to create wishlist table
        $wishlist_table_query = "CREATE TABLE wishlist_$buyer_id (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    product_id INT NOT NULL,
                                    FOREIGN KEY (product_id) REFERENCES products(id)
                                )";

        // Execute the SQL statement to create wishlist table
        if ($mysqli->query($wishlist_table_query) === TRUE) {
            // Wishlist table created successfully
            header("Location: index.php"); // Change this to the actual login page URL
            exit();
        } else {
            // Error creating wishlist table, handle error
            echo "Error creating wishlist table: " . $mysqli->error;
        }
    } else {
        // Signup failed, handle error
        echo "Error: " . $mysqli->error;
    }

    // Close statements
    $statement->close();

}

// Close database connection
$mysqli->close();

?>
