<?php
session_start();

if (isset($_SESSION['ROLE'])) {
    $role = $_SESSION['ROLE'];
} else {
    $role = null;
}

include 'admin/error.php';
include_once('admin/controller/database/db.php');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "Agro";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['ID'])) {
    echo "<script>alert('You need to log in to submit feedback.'); window.location.href = 'login.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : null;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : null;
    $message = isset($_POST['message']) ? mysqli_real_escape_string($conn, $_POST['message']) : null;

    $query = "INSERT INTO feedback (user_id, name, email, message) VALUES ('" . $_SESSION['ID'] . "', '$name', '$email', '$message')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Thanks for sending feedback'); window.location.href = 'index.php';</script>";
    } else {
        echo "Error submitting feedback: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <?php include 'css.php'; ?>
</head>
<body>
    <?php
    if ($role == 2) {
        include 'menu2.php';
    } else {
        include 'menu.php';
    }
    ?>
    <div class="row d-flex justify-content-center mt-3 mb-3">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mb-2">
                    <div class="card-header text text-dark text-center">
                        <h3>Feedback</h3>
                    </div>
                    <div class="card-body text text-dark">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control mb-3" name="name" id="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control mb-3" name="email" id="email" required>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control mb-3" name="message" id="message" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-center m-3 col-3 p-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'js.php'; ?>
</body>
</html>
