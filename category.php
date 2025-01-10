<?php session_start();
error_reporting(0);
include_once('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shopping Portal | Category wise Shop </title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <!-- Custom CSS for mobile responsiveness -->
        <style>
            /* Mobile-first design */
            .card-img-top {
                width: 100%; /* Make image full width */
                height: auto; /* Maintain aspect ratio */
            }

            /* Adjust card height for better layout on small screens */
            .card {
                border: none;
                margin-right: 15px; /* Add margin for spacing */
                margin-bottom: 20px; /* Add margin below the card */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add subtle shadow to cards */
            }

            .card-body {
                padding: 15px; /* Smaller padding for mobile */
            }

            .card-footer {
                padding: 10px 15px; /* Adjust footer padding */
            }

            .card-body h5 {
                font-size: 1rem; /* Slightly smaller font for better readability */
            }

            .text-decoration-line-through {
                font-size: 0.875rem;
            }

            /* Container holding the row of products */
            .products-row {
                display: flex;
                flex-wrap: nowrap; /* Prevent wrapping for a row format */
                overflow-x: auto; /* Enable horizontal scrolling on smaller screens */
                padding: 10px;
            }

            /* Style for the individual product item */
            .product-item {
                flex: 0 0 auto; /* Don't allow items to grow, maintain size */
                width: 200px; /* Fixed width for each product */
            }

            /* Media Queries for larger screens */
            @media (min-width: 576px) {
                .card {
                    margin-bottom: 20px; /* Less margin for small tablets */
                }
            }

            @media (min-width: 768px) {
                /* Adjust images and layout for tablets */
                .card-img-top {
                    height: 250px; /* Fixed height for tablets */
                }
            }

            @media (min-width: 992px) {
                /* 3 columns layout on medium screens */
                .products-row {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 20px; /* Add gap between items */
                }

                .card {
                    margin-bottom: 30px; /* Increase bottom margin for spacing */
                }
            }

            @media (min-width: 1200px) {
                /* 4 columns layout on larger screens */
                .products-row {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    gap: 30px; /* Add gap between items */
                }
            }
        </style>
    </head>
    <body>
        <?php include_once('includes/header.php'); ?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <?php 
                $cid = $_GET['cid'];
                $query = mysqli_query($con, "select category.id as catid, category.categoryName from category where id='$cid' ");
                while ($result = mysqli_fetch_array($query)) { ?>
                    <div class="text-center text-white">
                        <h1 class="display-4 fw-bolder"><?php echo $result['categoryName']; ?></h1>
                        <p class="lead fw-normal text-white-50 mb-0">Category Products/Items</p>
                    </div>
                <?php } ?>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="products-row">
                    <?php 
                    $query = mysqli_query($con, "select products.id as pid, products.productImage1, products.productName, products.productPriceBeforeDiscount, products.productPrice from products where category='$cid' order by pid desc ");
                    $count = mysqli_num_rows($query);
                    if ($count > 0) {
                        while ($row = mysqli_fetch_array($query)) { ?>
                            <div class="product-item">
                                <div class="card h-100">
                                    <!-- Product image-->
                                    <img class="card-img-top img-fluid" 
                                         src="admin/productimages/<?php echo htmlentities($row['productImage1']); ?>" 
                                         srcset="admin/productimages/<?php echo htmlentities($row['productImage1']); ?> 1x, admin/productimages/<?php echo htmlentities($row['productImage1']); ?> 2x"
                                         alt="<?php echo htmlentities($row['productName']); ?>" />
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <!-- Product name-->
                                            <h5 class="fw-bolder"><?php echo htmlentities($row['productName']); ?></h5>
                                            <!-- Product price-->
                                            <span class="text-decoration-line-through">$<?php echo htmlentities($row['productPriceBeforeDiscount']); ?></span> - $<?php echo htmlentities($row['productPrice']); ?>
                                        </div>
                                    </div>
                                    <!-- Product actions-->
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="product-details.php?pid=<?php echo htmlentities($row['pid']); ?>">View options</a></div>
                                    </div>
                                </div>
                            </div>
                        <?php } 
                    } else { ?>
                        <h4 style="color:red">No Record found</h4>
                    <?php } ?>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <?php include_once('includes/footer.php'); ?>
        <!-- Bootstrap core JS-->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
