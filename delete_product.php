<?php
// Include the init.php script to initialize the database connection and check user authentication
include 'init.php';

// Check if the user is authenticated and is a seller
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Seller') {
    // If not authenticated or not a seller, redirect to the login page
    header("Location: index.php");
    exit();
}

// Check if product ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect to seller home page if product ID is not provided
    header("Location: seller_home.php");
    exit();
}

// Retrieve product ID from the URL
$product_id = $_GET['id'];

// Fetch the image file path from the database
$query = "SELECT image FROM products WHERE id = ?";
$statement = $mysqli->prepare($query);
$statement->bind_param("i", $product_id);
$statement->execute();
$statement->bind_result($image);
$statement->fetch();
$statement->close();

// Check if the product exists in any wishlist table
$query = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'localmart' AND table_name LIKE 'wishlist_%'";
$result = $mysqli->query($query);

// Loop through wishlist tables
while ($row = $result->fetch_assoc()) {
    $wishlist_table = $row['table_name'];
    
    // Check if the product exists in the current wishlist table
    $query = "SELECT COUNT(*) FROM $wishlist_table WHERE product_id = ?";
    $statement = $mysqli->prepare($query);
    $statement->bind_param("i", $product_id);
    $statement->execute();
    $statement->bind_result($count);
    $statement->fetch();
    $statement->close();

    // If the product exists in the wishlist table, remove it
    if ($count > 0) {
        $query = "DELETE FROM $wishlist_table WHERE product_id = ?";
        $statement = $mysqli->prepare($query);
        $statement->bind_param("i", $product_id);
        $statement->execute();
        $statement->close();
    }
}

// Delete the product from the database
$query = "DELETE FROM products WHERE id = ?";
$statement = $mysqli->prepare($query);
$statement->bind_param("i", $product_id);
$statement->execute();
$statement->close();

// Delete the image file from the uploads directory
if (!empty($image)) {
    $image_path = "uploads/" . basename($image);
    if (file_exists($image_path)) {
        unlink($image_path); // Delete the file
    }
}

// Close database connection
$mysqli->close();

// Redirect to seller home page after deleting the product
header("Location: seller_home.php");
exit();
?>
