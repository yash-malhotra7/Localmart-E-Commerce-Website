<?php
// Include the init.php script to initialize the database connection and check user authentication
include 'init.php';

// Check if the user is authenticated as a buyer
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Buyer') {
    // If not authenticated or not a buyer, redirect to the login page
    header("Location: index.php");
    exit();
}

// Retrieve wishlist items for the current user from the database
$userId = $_SESSION['userid'];
$wishlistTableName = "wishlist_" . $userId; // Construct the wishlist table name
$query = "SELECT p.id AS product_id, p.name AS product_name, p.price AS price, p.image AS product_image 
          FROM $wishlistTableName AS w 
          INNER JOIN products AS p ON w.product_id = p.id";
$result = $mysqli->query($query);

// Close database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        .container {
            margin-top: 50px;
        }
        .btn-back {
            margin-bottom: 20px;
        }
        .product-image {
            max-width: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Wishlist</h2>
        <button class="btn btn-primary btn-back" onclick="window.location.href = 'buyer_home.php';">Back</button>
        
        <!-- Wishlist Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S. No</th>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Buy</th> <!-- Added Buy column -->
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php $serialNumber = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $serialNumber++; ?></td>
                        <td><img src="<?php echo $row['product_image']; ?>" alt="Product Image" class="product-image"></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td>₹<?php echo $row['price']; ?></td>
                        <td><a href="product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-success" id="buyBtn_<?php echo $row['product_id']; ?>" disabled>Buy</a></td> <!-- Added Buy button with ID -->
                        <td><input type="checkbox" data-product-id="<?php echo $row['product_id']; ?>" onchange="enableBuyButtons()"></td> <!-- Added onchange event -->
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Remove Button -->
        <button class="btn btn-danger" id="removeBtn" onclick="removeSelected()" disabled>Remove Selected</button> <!-- Disabled by default -->

        <!-- Buy Button -->
        <button class="btn btn-primary" id="buyAllBtn" onclick="buySelected()" disabled>Buy</button> <!-- Disabled by default -->
    </div>

    <!-- Bootstrap JS and jQuery (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Function to enable/disable buy buttons based on checkbox selection
        function enableBuyButtons() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var selectedCount = 0;

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    selectedCount++;
                    // Enable corresponding buy button
                    document.getElementById("buyBtn_" + checkbox.dataset.productId).removeAttribute("disabled");
                } else {
                    // Disable corresponding buy button
                    document.getElementById("buyBtn_" + checkbox.dataset.productId).setAttribute("disabled", "true");
                }
            });

            // Enable/disable remove button
            var removeBtn = document.getElementById("removeBtn");
            removeBtn.disabled = (selectedCount === 0);

            // Enable/disable buy all button
            var buyAllBtn = document.getElementById("buyAllBtn");
            buyAllBtn.disabled = (selectedCount === 0);
        }

         // Function to remove selected wishlist items
         function removeSelected() {
            // Get all checkboxes
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var selectedProducts = [];

            // Iterate through checkboxes to find selected items
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    // Get the corresponding product ID or other identifier and add it to the list
                    selectedProducts.push(checkbox.dataset.productId);
                }
            });

            // Send AJAX request to remove selected products from wishlist
            $.post('remove_from_wishlist.php', { products: selectedProducts }, function(response) {
                // Handle the response accordingly
                if (response === "removed") {
                    // Products successfully removed, reload the page
                    location.reload();
                } else {
                    // Display an error message
                    alert("Failed to remove selected products from wishlist.");
                }
            });
        }

        // Function to buy selected wishlist items
        function buySelected() {
            // Implementation of buySelected function...
        }
    </script>
</body>
</html>
