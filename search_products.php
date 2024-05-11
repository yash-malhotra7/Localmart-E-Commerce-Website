<?php
// Include the init.php script to initialize the database connection
include 'init.php';

// Check if the request is made using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the search query from the AJAX request
    $searchQuery = $_POST['search_query'];

    // Prepare the SQL query to fetch filtered product list from the database
    $query = "SELECT * FROM products WHERE name LIKE ?"; // Base query

    // Prepare the statement
    $statement = $mysqli->prepare($query);

    // Bind the search query parameter
    $searchParam = "%" . $searchQuery . "%";
    $statement->bind_param("s", $searchParam);

    // Execute the statement
    $statement->execute();

    // Get the result
    $result = $statement->get_result();

    // Check if there are any matching products
    if ($result->num_rows > 0) {
        // Display the filtered product list
        while ($row = $result->fetch_assoc()) {
            // Output HTML markup for each product card
            echo '<div class="col-md-4">';
            echo '<div class="card product-card">';
            echo '<img class="card-img-top product-image" src="' . $row['image'] . '" alt="Product Image">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $row['name'] . '</h5>';
            echo '<p class="card-text">Price: $' . $row['price'] . '</p>';
            echo '<a href="product.php?id=' . $row['id'] . '" class="btn btn-primary">Buy</a>';
            echo '<button class="btn btn-outline-secondary like-btn" data-product-id="' . $row['id'] . '" onclick="toggleLike(' . $row['id'] . ')"><i class="fa-regular fa-heart"></i></button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        // No matching products found
        echo 'No products found';
    }

    // Close statement
    $statement->close();
} else {
    // Invalid request method
    echo "invalid_request";
}

// Close database connection
$mysqli->close();
?>
