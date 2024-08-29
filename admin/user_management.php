<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "Agro";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$role = isset($_SESSION['ROLE']) ? $_SESSION['ROLE'] : null;

// Handle user actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = isset($_POST['user_id']) && !empty($_POST['user_id']) ? 'edit' : 'add';
    $userId = $_POST['user_id'] ?? null;
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = isset($_POST['pass']) ? password_hash($_POST['pass'], PASSWORD_BCRYPT) : null;

    if ($action == 'add') {
        $stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, pass) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
    } else {
        if (isset($_POST['delete'])) {
            $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $userId);
        } else {
            $stmt = mysqli_prepare($conn, "UPDATE users SET username = ?, email = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "ssi", $username, $email, $userId);
        }
    }

    if ($stmt) {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}

// Fetch users
$result = mysqli_query($conn, "SELECT * FROM users");
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($conn);
?>
<?php 
include 'error.php';
session_start();
include_once('controller/database/db.php');
if (!isset($_SESSION['ID'])) {
    include 'logout.php';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <?php include 'css.php'; ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin-top: 20px;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            border: none;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <?php 
    if($role == 2) {
        include 'menu2.php';
    } else {
        include 'menu.php';
    }
    ?>
 
    <div class="container">
        <h1 class="text text-light">User Management</h1>

        <div class="card">
            <h2>Manage User</h2>
            <form method="POST" action="">
                <input type="hidden" name="user_id" id="user_id">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div class="form-group">
                    <label for="surname">surname:</label>
                    <input type="text" name="surname" id="surname" required>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="pass" id="pass">
                </div>
                <button type="submit">Save User</button>
                <button type="submit" name="delete">Delete User</button>
            </form>
        </div>

        <div class="card">
            <h2>User List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr onclick="editUser('<?php echo $user['id']; ?>', '<?php echo htmlspecialchars($user['username']); ?>', '<?php echo htmlspecialchars($user['email']); ?>')">
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function editUser(id, username, email) {
            document.getElementById('user_id').value = id;
            document.getElementById('username').value = username;
            document.getElementById('email').value = email;
        }
    </script>
    <?php include 'js.php'; ?>
</body>
</html>
