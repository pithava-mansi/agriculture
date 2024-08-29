<?php

$servername="localhost";
$username="root";
$password="";
$database="Agro";

//create connection

$conn=mysqli_connect($servername,$username,$password,$database);
if(!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}
else{
   // echo "connected";
}

// mysqli_close($conn);

?>
<?php

$sql="CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
)";
if($sql==true)
{
    echo 'table created success fully';
}
?>
