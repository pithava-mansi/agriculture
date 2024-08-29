<!-- 

<?php
session_start();
include 'controller/database/db.php'; // Database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['ID']) || $_SESSION['ROLE'] != 0) {
    header("Location: login.php");
    exit();
}

// Fetch some data for the dashboard (example: total users, total categories)
$query = "SELECT COUNT(*) as total_users FROM users";
$result = $conn->query($query);
$totalUsers = $result->fetch_assoc()['total_users'];

$query = "SELECT COUNT(*) as total_categories FROM categories";
$result = $conn->query($query);
$totalCategories = $result->fetch_assoc()['total_categories'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <?php include 'css.php'; ?>
    <style>
        /* Basic styling for the dashboard */
        .dashboard-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            color: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .dashboard-card h3 {
            margin-bottom: 15px;
        }

        .dashboard-card p {
            margin: 5px 0;
        }

        .dashboard-card a {
            color: #fff;
            text-decoration: none;
        }

        .dashboard-card a.btn {
            margin-right: 10px;
        }

        .dashboard-card a.btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .dashboard-card a.btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .dashboard-card a.btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .dashboard-card a.btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; // Include navigation menu ?>
    <?php 
//include 'error.php';

// Include database connection file
include_once('controller/database/db.php');
if (!isset($_SESSION['ID'])) {
include 'logout.php';
	exit();
}
if(0==$_SESSION['ROLE']){
?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="dashboard-card">
                    <h3>Welcome to the Admin Dashboard</h3>
                    <p>Total Users: <?php echo htmlspecialchars($totalUsers); ?></p>
                    <p>Total Categories: <?php echo htmlspecialchars($totalCategories); ?></p>
                    <div>
                        <a href="category.php" class="btn btn-primary">Manage Categories</a>
                        <a href="user_management.php" class="btn btn-primary">Manage Users</a>
                        <a href="analytics.php" class="btn btn-primary">View Analytics</a>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'js.php'; // Include JavaScript files ?>
</body>
</html>
<?php }else{
            include 'logout.php';
        }
        
        ?> -->