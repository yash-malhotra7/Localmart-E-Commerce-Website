<?php
// Include the init.php script to initialize the database connection
include 'init.php';

// Check if the request is made using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve selected product IDs from the request
    $selectedProducts = $_POST['products'];

    // Check if the selectedProducts array is not empty
    if (!empty($selectedProducts)) {
        // Construct the wishlist table name for the current user
        session_start();
        $userId = $_SESSION['userid'];
        $wishlistTableName = "wishlist_" . $userId;

        // Prepare the SQL query to delete selected products from the wishlist table
        $query = "DELETE FROM $wishlistTableName WHERE product_id IN (" . implode(",", $selectedProducts) . ")";

        // Execute the query
        if ($mysqli->query($query)) {
            // Removal successful
            echo "removed";
        } else {
            // Removal failed
            echo "error";
        }
    } else {
        // No products selected
        echo "no_selection";
    }
} else {
    // Invalid request method
    echo "invalid_request";
}

// Close database connection
$mysqli->close();
?>
