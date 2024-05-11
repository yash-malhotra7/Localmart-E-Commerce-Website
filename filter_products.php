<?php
// Include the init.php script to initialize the database connection
include 'init.php';


// Check if the request is made using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the filtering options from the AJAX request
    $sortBy = $_POST['sort_by'];
    $minPrice = $_POST['min_price'];
    $maxPrice = $_POST['max_price'];

    // Prepare the SQL query to fetch filtered product list from the database
    $query = "SELECT * FROM products WHERE 1=1"; // Base query
    
    // Add filtering conditions based on user's selection
    if (!empty($minPrice)) {
        $query .= " AND price >= ?";
    }
    if (!empty($maxPrice)) {
        $query .= " AND price <= ?";
    }
    
    // Add sorting condition
    $query .= " ORDER BY ";
    if ($sortBy == "price") {
        $query .= "price ASC";
    } elseif ($sortBy == "name") {
        $query .= "name ASC";
    }

    // Prepare the statement
    $statement = $mysqli->prepare($query);

    // Bind parameters if necessary
    if (!empty($minPrice) && !empty($maxPrice)) {
        $statement->bind_param("dd", $minPrice, $maxPrice);
    } elseif (!empty($minPrice)) {
        $statement->bind_param("d", $minPrice);
    } elseif (!empty($maxPrice)) {
        $statement->bind_param("d", $maxPrice);
    }

    // Execute the statement
    $statement->execute();

    // Get the result
    $result = $statement->get_result();

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

    // Close statement
    $statement->close();
} else {
    // Invalid request method
    echo "invalid_request";
}

// Close database connection
$mysqli->close();
?>
