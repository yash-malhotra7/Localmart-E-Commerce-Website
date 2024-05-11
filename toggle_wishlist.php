<?php
// Include the init.php script to initialize the database connection
include 'init.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve product ID and like status from the AJAX request
    $productId = $_POST['productId'];
    $isLiked = $_POST['isLiked'];

    // Check if the user is logged in and is a buyer (you may need to adjust this based on your authentication logic)
    session_start();
    if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Buyer') {
        // If not authenticated or not a buyer, return an error response
        http_response_code(401); // Unauthorized
        exit("Unauthorized access");
    }

    // Retrieve buyer's ID from session
    $buyerId = $_SESSION['userid'];

    // Check if the product is already in the wishlist
    $query = "SELECT * FROM wishlist_$buyerId WHERE product_id = ?";
    $statement = $mysqli->prepare($query);
    $statement->bind_param("i", $productId);
    $statement->execute();
    $result = $statement->get_result();

    // If the product is already in the wishlist and the user wants to remove it
    if ($result->num_rows > 0 && $isLiked == 'true') {
        // Remove the product from the wishlist
        $deleteQuery = "DELETE FROM wishlist_$buyerId WHERE product_id = ?";
        $deleteStatement = $mysqli->prepare($deleteQuery);
        $deleteStatement->bind_param("i", $productId);
        $deleteStatement->execute();

        // Close statement
        $deleteStatement->close();

        // Return response indicating product was removed
        echo "removed";
    }
    // If the product is not in the wishlist and the user wants to add it
    elseif ($result->num_rows == 0 && $isLiked == 'false') {
        // Add the product to the wishlist
        $insertQuery = "INSERT INTO wishlist_$buyerId (product_id) VALUES (?)";
        $insertStatement = $mysqli->prepare($insertQuery);
        $insertStatement->bind_param("i", $productId);
        $insertStatement->execute();

        // Close statement
        $insertStatement->close();

        // Return response indicating product was added
        echo "added";
    } else {
        // Return response indicating no action was taken
        echo "no_action";
    }

    // Close statement
    $statement->close();
}

// Close database connection
$mysqli->close();
?>
