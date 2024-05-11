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

// Retrieve seller's products from the database
$query = "SELECT * FROM products WHERE seller_id = ?";
$statement = $mysqli->prepare($query);
$statement->bind_param("i", $_SESSION['userid']);
$statement->execute();
$result = $statement->get_result();

// Close statement
$statement->close();

// Close database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Home</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/product_display.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
        <img src="images/logo-PNG.png" alt="Localmart" width="80" height="30" class="d-inline-block align-top">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="logout();"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col-md-8"> <!-- Aligning content to the left -->
                <h2>Your Products</h2>
            </div>
            <div class="col-md-4 text-right"> <!-- Aligning content to the right -->
                <a href="add_product.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a> <!-- Add Product button -->
            </div>
        </div>
        <?php if ($result->num_rows > 0): ?>
            <div class="col-md-9">
                <div class="row product-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-md-4">
                            <div class="card product-card">
                                <img class="card-img-top product-image" src="<?php echo $row['image']; ?>" alt="Product Image">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                    <p class="card-text">Price: $<?php echo $row['price']; ?></p>
                                    <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">
                                        <i class="fas fa-file-signature"></i>
                                    </a>
                                    <button class="btn btn-danger" onclick="deleteProduct(<?php echo $row['id']; ?>)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php else: ?>
            <p>You currently do not have any products.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS and jQuery (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function logout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php";
            }
        }
        
        function deleteProduct(productId) {
            if (confirm("Are you sure you want to delete this product?")) {
                window.location.href = "delete_product.php?id=" + productId;
            }
        }
    </script>
</body>
</html>
