<?php
session_start();

// Ensure 'ROLE' is set in the session before accessing it
if (isset($_SESSION['ROLE'])) {
    $role = $_SESSION['ROLE'];
   // echo $role;
} else {
    $role = null; // Or set a default value, or handle the case when the role is not set
    //echo $role;
}
include 'admin/error.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <?php include 'css.php';  ?>

</head>

<body>
<?php
        // Check the user's role and include the appropriate menu
        if ($role == 2) {
            include 'menu2.php';
        } else {
            include 'menu.php';
        }
    ?>
    <div class="row  d-flex  justify-content-center  mt-3 mb-3">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mb-2">
                    <div class="card-header text text-dark text-center">
                        <h3>About Us</h3>
                    </div>

                    <div class="card-body text text-dark">
                        <p>Welcome to our online shop! We specialize in providing the best agricultural products.</p>
                        <p>Our mission is to support farmers and deliver high-quality products to our customers.</p>
                        <p>With years of experience in the industry, we strive to offer a wide range of products that
                            meet the needs of our diverse clientele.</p>
                        <p>Thank you for choosing us. We look forward to serving you!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <?php include 'js.php';  ?>
</body>

</html>