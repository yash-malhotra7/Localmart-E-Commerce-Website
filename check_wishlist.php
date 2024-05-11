<?php
// Include the init.php script to initialize the database connection
include 'init.php';

// Check if the request is made using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the product ID from the request
    $productId = $_POST['product_id'];

    // Check if the product is in the user's wishlist
    session_start();
    $userId = $_SESSION['userid'];
    $wishlistTableName = "wishlist_" . $userId; // Construct the wishlist table name

    // Prepare the SQL query to check if the product exists in the user's wishlist
    $query = "SELECT COUNT(*) AS count FROM $wishlistTableName WHERE product_id = ?";
    $statement = $mysqli->prepare($query);
    $statement->bind_param("i", $productId);
    $statement->execute();
    $result = $statement->get_result();

    // Fetch the count of matching rows
    $row = $result->fetch_assoc();
    $count = $row['count'];

    // Close statement
    $statement->close();

    // Check if the product exists in the user's wishlist
    if ($count > 0) {
        // Product is in the user's wishlist
        echo "in_wishlist";
    } else {
        // Product is not in the user's wishlist
        echo "not_in_wishlist";
    }
} else {
    // Invalid request method
    echo "invalid_request";
}

// Close database connection
$mysqli->close();
?>
