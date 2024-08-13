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

//sql to create feedback table
$sql = "CREATE TABLE feedback (
        name VARCHAR(255)NOT NULL,
        email VARCHAR(255)NOT NULL,
        message VARCHAR(255)NOT NULL
        
    )";
if (mysqli_query($conn, $sql)) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}


mysqli_close($conn);

?>