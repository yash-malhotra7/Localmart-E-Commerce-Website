<?php
// Include the init.php script to initialize the database connection
include 'init.php';

// Retrieve all products from the database
$query = "SELECT * FROM products";
$result = $mysqli->query($query);

// Close database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Home</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/product_display.css">
    <style>
        
    </style>
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
                    <a class="nav-link" href="wishlist.php" id="wishlistButton"><i class="fas fa-heart"></i> Wishlist</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="logout();"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </nav>
        <!-- Search bar -->
        <div class="row mb-3">
            <div class="container-fluid py-3">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="Search for products">
                            <button class="btn btn-primary" type="button" id="searchBtn"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Sidebar with filtering options -->
            <div class="col-md-3 sidebar">
                <!-- Stylish header for filtering options -->
                <div class="p-3 mb-3 bg-primary text-white">
                    <h4 class="m-0">Filter By</h4>
                </div>

                <!-- Filtering options with modern input styles -->
                <div class="form-group">
                    <label for="sortBy">Sort By:</label>
                    <select class="form-control" id="sortBy">
                        <option value="price">Price</option>
                        <option value="name">Name</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="minPrice">Min Price:</label>
                    <input type="number" class="form-control" id="minPrice" placeholder="Enter minimum price">
                </div>
                <div class="form-group">
                    <label for="maxPrice">Max Price:</label>
                    <input type="number" class="form-control" id="maxPrice" placeholder="Enter maximum price">
                </div>
                <button class="btn btn-primary btn-block" id="applyFiltersBtn">Apply Filters</button>
            </div>

            <!-- Product display area -->
            <div class="col-md-9">
                <div class="row product-list">
                    <!-- Display each product as a card -->
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-md-4">
                            <div class="card product-card">
                                <img class="card-img-top product-image" src="<?php echo $row['image']; ?>" alt="Product Image">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                    <p class="card-text">Price: ₹<?php echo $row['price']; ?></p>
                                    <a href="product.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Buy</a>
                                    <button class="btn btn-outline-secondary like-btn" data-product-id="<?php echo $row['id']; ?>" onclick="toggleLike(<?php echo $row['id']; ?>)">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

    <!-- HTML markup for the image pop-up -->
    <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <img id="modalImage" class="modal-content">
    </div>

    <!-- Bootstrap JS and jQuery (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="jQuery_zoom/css/image-zoom.css"/>
    <script src="jQuery_zoom/js/vendor/jquery.min.js"></script>
    <script src="jQuery_zoom/dist/js/image-zoom.min.js"></script>


    <!-- Magnific Popup core JS file -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <!-- Font Awesome JS (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://kit.fontawesome.com/1bfc5e6715.js" crossorigin="anonymous"></script>
    <!-- Custom JavaScript -->
    <script>
        // Add custom JavaScript here
        function logout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php";
            }
        }

        function toggleLike(productId) {
            var likeButton = $('.like-btn[data-product-id="' + productId + '"]');
            var isLiked = likeButton.hasClass('liked');
            var icon = likeButton.find('i');

            // Send AJAX request to add/remove product from wishlist
            $.ajax({
                type: 'POST',
                url: 'toggle_wishlist.php',
                data: { productId: productId, isLiked: isLiked },
                success: function(response) {
                    console.log('AJAX response:', response);

                    // Update icon classes based on AJAX response
                    if (response === 'added') {
                        icon.removeClass('fa-regular fa-heart').addClass('fa-solid fa-heart');
                        likeButton.addClass('liked');
                    } else if (response === 'removed') {
                        icon.removeClass('fa-solid fa-heart').addClass('fa-regular fa-heart');
                        likeButton.removeClass('liked');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                }
            });
        }

        $(document).ready(function() {
            $('.like-btn').hover(function() {
                var icon = $(this).find('i');
                if ($(this).hasClass('liked')) {
                    icon.removeClass('fa-heart').addClass('fa-heart-crack');
                } else {
                    icon.removeClass('fa-heart').addClass('fa-solid fa-heart');
                }
            }, function() {
                var icon = $(this).find('i');
                if ($(this).hasClass('liked')) {
                    icon.removeClass('fa-heart-crack').addClass('fa-solid fa-heart');
                } else {
                    icon.removeClass('fa-solid fa-heart').addClass('fa-regular fa-heart');
                }
            });
        });

        // Function to update like buttons based on user's wishlist
        function updateLikeButtons() {
            // Get all like buttons on the page
            var likeButtons = document.querySelectorAll('.like-btn');

            // Iterate through each like button
            likeButtons.forEach(function(button) {
                // Get the product ID associated with the button
                var productId = button.dataset.productId;
                var icon = button.querySelector('i'); // Ensure you target the icon inside the button   

                // Send AJAX request to check if the product is in the user's wishlist
                $.post('check_wishlist.php', { product_id: productId }, function(response) {
                    // Handle the response
                    if (response === "in_wishlist") {
                        // Product is in the user's wishlist, update button style
                        button.classList.add('liked');
                        icon.className = 'fa fa-solid fa-heart'; // Update the icon class to reflect liked state
                    }
                });
            });
        }

        // Call the function when the page is loaded
        $(document).ready(function() {
            updateLikeButtons();
        });

        // Image popup functionality with zoom
        $(document).ready(function() {
            // Initialize the jQuery Zoom plugin
            $('.product-image').zoom({
                on: 'click' // Zoom when the image is clicked
            });

            // Image pop-up functionality
            $('.product-image').click(function() {
                var imageSrc = $(this).attr('src');
                $('#modalImage').attr('src', imageSrc);
                $('#imageModal').css('display', 'block');
            });

            // Close the modal when the user clicks outside of it
            $(window).click(function(event) {
                if (event.target == $('#imageModal')[0]) {
                    $('#imageModal').css('display', 'none');
                }
            });

            // Close the modal when the user clicks the close button
            $('.close').click(function() {
                $('#imageModal').css('display', 'none');
            });

            // Zoom in and out using scroll keys
            $(document).on('keydown', function(e) {
                if ($('#modalImage').is(':visible')) {
                    if (e.keyCode == 187 || e.keyCode == 107) { // '+' key or '=' key (zoom in)
                        $('.product-image').trigger('zoom.in');
                    } else if (e.keyCode == 189 || e.keyCode == 109) { // '-' key (zoom out)
                        $('.product-image').trigger('zoom.out');
                    }
                }
            });
        });

        // Filter products functionality
        $(document).ready(function() {
            // Event listener for the "Apply Filters" button
            $('#applyFiltersBtn').click(function() {
                // Get the selected sorting criteria, minimum price, and maximum price
                var sortBy = $('#sortBy').val();
                var minPrice = $('#minPrice').val();
                var maxPrice = $('#maxPrice').val();

                // Send AJAX request to server to get filtered product list
                $.post('filter_products.php', {
                    sort_by: sortBy,
                    min_price: minPrice,
                    max_price: maxPrice
                }, function(response) {
                    // Update the product list with filtered data
                    $('.product-list').html(response);

                    // Reinitialize image popup functionality after the filtered products are loaded
                initializeImagePopup();
                updateLikeButtons();
                });
            });
        });

        

        // Image pop-up functionality
        $(document).ready(function() {
            $('.product-image').click(function() {
                var imageSrc = $(this).attr('src');
                $('#modalImage').attr('src', imageSrc);
                $('#imageModal').css('display', 'block');
            });

            // Close the modal when the user clicks outside of it
            $(window).click(function(event) {
                if (event.target == $('#imageModal')[0]) {
                    $('#imageModal').css('display', 'none');
                }
            });

            // Close the modal when the user clicks the close button
            $('.close').click(function() {
                $('#imageModal').css('display', 'none');
            });
        });

        // Search products functionality
        $(document).ready(function() {
            // Event listener for the search button
            $('#searchBtn').click(function() {
                // Get the search query entered by the user
                var searchQuery = $('#searchInput').val().trim();

                // Send AJAX request to server to search for products
                $.post('search_products.php', {
                    search_query: searchQuery
                }, function(response) {
                    // Update the product list with the filtered products
                    $('.product-list').html(response);

                    initializeImagePopup();
                    updateLikeButtons();
                });
            });

            // Event listener for the form submission (optional)
            $('#searchForm').submit(function(event) {
                // Prevent the default form submission behavior
                event.preventDefault();

                // Trigger the click event for the search button
                $('#searchBtn').click();
            });
        });
    </script>
    <style>
        /* CSS for the image pop-up */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 50%;
            max-height: 100%;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #ccc;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</body>
</html>
