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

// Define variables to store product data
$product_name = $product_description = $product_price = "";
$product_image = $current_image = "";
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $current_image = $_POST['current_image'];

    // Check if all required fields are filled
    if (empty($product_name) || empty($product_description) || empty($product_price)) {
        $error_message = "Please fill in all the required fields.";
    } else {
        // Check if a new image file is uploaded
        if ($_FILES['product_image']['size'] > 0) {
            // Handle file upload
            $target_dir = "uploads/"; // Directory where uploaded images will be stored
            $target_file = $target_dir . basename($_FILES['product_image']['name']);
            $upload_ok = 1;
            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if the file is an actual image
            $check = getimagesize($_FILES['product_image']['tmp_name']);
            if ($check === false) {
                $error_message = "File is not an image.";
                $upload_ok = 0;
            }

            // Check file size (max 5MB)
            if ($_FILES['product_image']['size'] > 5000000) {
                $error_message = "File is too large.";
                $upload_ok = 0;
            }

            // Allow only certain file formats
            if ($image_file_type != "jpg" && $image_file_type != "jpeg" && $image_file_type != "png" && $image_file_type != "gif") {
                $error_message = "Only JPG, JPEG, PNG & GIF files are allowed.";
                $upload_ok = 0;
            }

            // Check if $upload_ok is set to 0 by an error
            if ($upload_ok == 0) {
                $error_message .= " Your file was not uploaded.";
            } else {
                // Try to upload file
                if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
                    // File uploaded successfully, update product image
                    $product_image = $target_file;
                } else {
                    // Error uploading file
                    $error_message = "There was an error uploading your file.";
                }
            }
        } else {
            // No new image uploaded, retain current image
            $product_image = $current_image;
        }

        // Update product data in the database
        $query = "UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?";
        $statement = $mysqli->prepare($query);
        $statement->bind_param("ssdsi", $product_name, $product_description, $product_price, $product_image, $product_id);
        if ($statement->execute()) {
            // Product updated successfully, redirect to seller home page
            header("Location: seller_home.php");
            exit();
        } else {
            // Error updating product data
            $error_message = "Error updating product. Please try again.";
        }
    }
}

// Retrieve existing product data from the database
$query = "SELECT * FROM products WHERE id = ?";
$statement = $mysqli->prepare($query);
$statement->bind_param("i", $product_id);
$statement->execute();
$result = $statement->get_result();

// Check if the product exists
if ($result->num_rows == 1) {
    // Fetch product data
    $product = $result->fetch_assoc();
    $product_name = $product['name'];
    $product_description = $product['description'];
    $product_price = $product['price'];
    $current_image = $product['image'];
} else {
    // Product does not exist, redirect to seller home page
    header("Location: seller_home.php");
    exit();
}

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
    <title>Edit Product</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Product</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $product_id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_description">Product Description</label>
                <textarea class="form-control" id="product_description" name="product_description" rows="3" required><?php echo $product_description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="product_price">Product Price</label>
                <input type="number" class="form-control" id="product_price" name="product_price" min="0.01" step="0.01" value="<?php echo $product_price; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_image">Product Image</label>
                <input type="file" class="form-control-file" id="product_image" name="product_image" accept="image/*">
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <small class="form-text text-muted">Leave blank if you do not wish to change the image.</small>
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS and jQuery (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
