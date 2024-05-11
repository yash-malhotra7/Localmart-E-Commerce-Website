<?php
// Include the init.php script to initialize the database connection
include 'init.php';

// Check if the product ID is set in the URL
if(isset($_GET['id'])) {
    // Retrieve the product ID from the URL
    $productId = $_GET['id'];

    // Prepare an SQL statement to fetch the product details from the database based on its ID
    $query = "SELECT * FROM products WHERE id = ?";
    $statement = $mysqli->prepare($query);

    // Bind the product ID parameter
    $statement->bind_param("i", $productId);

    // Execute the prepared statement
    $statement->execute();

    // Get the result of the query
    $result = $statement->get_result();

    // Check if a product with the given ID exists
    if($result->num_rows > 0) {
        // Fetch the product details
        $product = $result->fetch_assoc();

        // Close the prepared statement
        $statement->close();
    } else {
        // Product with the given ID not found, handle error or redirect
        // For example:
        header("Location: buyer_home.php");
        exit();
    }
} else {
    // Product ID not provided in the URL, handle error or redirect
    // For example:
    header("Location: buyer_home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        /* Add custom CSS styles here */
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .container {
            padding-top: 20px;
        }
        .product-details {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .product-image {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-light bg-light">
    <div class="container">
        <!-- Back button -->
        <a class="navbar-brand" href="buyer_home.php">
            <i class="fas fa-chevron-left"></i> Back
        </a>
        <!-- Buy button -->
        <a href="#" class="btn btn-primary">Buy Now</a>
    </div>
</nav>

<!-- Main content -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Product details -->
            <div class="product-details">
                <!-- Product image -->
                <img src="<?php echo $product['image']; ?>" class="product-image mb-4" alt="Product Image">
                <!-- Product name and price -->
                <h2 class="mb-3"><?php echo $product['name']; ?></h2>
                <p class="text-muted">$<?php echo $product['price']; ?></p>
                <!-- Product description -->
                <p class="mb-4"><?php echo $product['description']; ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<!-- Bootstrap JS and jQuery (optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
