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

// Handle user actions
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'add') {
        // Add user
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        $stmt->execute();
        $stmt->close();

    } elseif ($action == 'edit') {
        // Edit user
        $userId = $_POST['user_id'];
        $username = $_POST['username'];
        $email = $_POST['email'];

        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $username, $email, $userId);
        $stmt->execute();
        $stmt->close();

    } elseif ($action == 'delete') {
        // Delete user
        $userId = $_POST['user_id'];

        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch users
$result = mysqli_query($conn, "SELECT * FROM users");
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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

        h1 {
            color: #333;
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

        .card h2 {
            margin-top: 0;
            color: #333;
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
    <div class="container">
        <h1>User Management</h1>

        <!-- Add User Form -->
        <div class="card">
            <h2>Add User</h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add">
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
                    <input type="password" name="password" id="password" required>
                </div>
                <button type="submit">Add User</button>
            </form>
        </div>

        <!-- Edit User Form -->
        <div class="card">
            <h2>Edit User</h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="edit">
                <div class="form-group">
                    <label for="user_id">User ID:</label>
                    <input type="number" name="user_id" id="user_id" required>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <button type="submit">Update User</button>
            </form>
        </div>

        <!-- Delete User Form -->
        <div class="card">
            <h2>Delete User</h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="delete">
                <div class="form-group">
                    <label for="user_id">User ID:</label>
                    <input type="number" name="user_id" id="user_id" required>
                </div>
                <button type="submit">Delete User</button>
            </form>
        </div>

        <!-- User List -->
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
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include 'js.php'; ?>
</body>
</html>
