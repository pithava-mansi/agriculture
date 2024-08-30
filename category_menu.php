<?php
session_start();

// Ensure 'ROLE' is set in the session before accessing it
if (isset($_SESSION['ROLE'])) {
    $role = $_SESSION['ROLE'];
} else {
    $role = null; // Or set a default value, or handle the case when the role is not set
}

// Include necessary files and handle database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "Agro";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch categories
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include 'css.php';?>
    <style>
        /* Style the category menu to be inline */
        .category-menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Center the items horizontally */
            background-color: #f8f9fa; /* Light background color */
        }

        .category-menu .nav-item {
            margin: 0 10px; /* Add some space between items */
        }

        .category-menu .nav-link {
            text-decoration: none;
            color: #333;
            padding: 10px 15px;
            display: block;
        }

        .category-menu .nav-link:hover {
            background-color: #e2e6ea; /* Slightly darker background on hover */
            color: #000;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php
    if ($role == 2) {
        include 'menu2.php';
    } else {
        include 'menu.php';
    }

    if ($result->num_rows > 0) {
        echo '<ul class="category-menu">';
        
        // Loop through each category and display it as a navbar item
        while ($row = $result->fetch_assoc()) {
            echo '<li class="nav-item"> 
                    <a class="nav-link" href="product.php?category=' . $row['category_name'] . '">' . $row['category_name'] . '</a>
                  </li>';
        }
        
        echo '</ul>';
    } else {
        echo "No categories found.";
    }

    $conn->close();
    ?>
    <?php include 'js.php';?>
</body>
</html>
