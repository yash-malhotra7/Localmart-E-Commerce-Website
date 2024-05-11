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

// Define variables to store form data
$product_name = $product_description = $product_image = $product_price = "";
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];

    // Check if all required fields are filled
    if (empty($product_name) || empty($product_description) || empty($product_price) || empty($_FILES['product_image']['name'])) {
        $error_message = "Please fill in all the required fields.";
    } else {
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

        // Check if file already exists
        if (file_exists($target_file)) {
            $error_message = "File already exists.";
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
                // File uploaded successfully, insert product data into database
                $product_image = $target_file;

                // Insert product data into database
                $query = "INSERT INTO products (name, description, price, image, seller_id) VALUES (?, ?, ?, ?, ?)";
                $statement = $mysqli->prepare($query);
                $statement->bind_param("ssdsi", $product_name, $product_description, $product_price, $product_image, $_SESSION['userid']);
                if ($statement->execute()) {
                    // Product added successfully, redirect to seller home page
                    header("Location: seller_home.php");
                    exit();
                } else {
                    // Error inserting product data
                    $error_message = "Error adding product. Please try again.";
                }
            } else {
                // Error uploading file
                $error_message = "There was an error uploading your file.";
            }
        }
    }
}

// Close database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f7f7; /* Light grey background */
            font-family: 'Arial', sans-serif; /* Modern font */
        }
        .container {
            background: white; /* White background for the form area */
            padding: 20px; /* Padding around the content */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            margin-top: 50px; /* Margin to the top */
        }
        .btn-primary {
            background-color: #0056b3; /* Custom primary color */
            border: none; /* No border */
            padding: 10px 20px; /* Padding for button */
            font-size: 16px; /* Larger font size */
        }
        h2 {
            color: #333; /* Dark grey color for the title */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Product</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_description">Description</label>
                <textarea class="form-control" id="product_description" name="product_description" rows="3" required><?php echo $product_description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="product_price">Price ($)</label>
                <input type="number" step="0.01" class="form-control" id="product_price" name="product_price" value="<?php echo $product_price; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_image">Product Image</label>
                <input type="file" class="form-control-file" id="product_image" name="product_image" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
        <!-- Display error message if any -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger mt-3">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap and jQuery scripts for responsive functionality -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
