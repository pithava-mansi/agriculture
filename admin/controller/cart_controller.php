<?php

class CartController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Function to add an item to the cart
    public function addToCart($userId, $productId, $quantity, $price) {
        $sql = "INSERT INTO cart_items (user_id, product_id, quantity, price, date_added) 
                VALUES (:user_id, :product_id, :quantity, :price, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':product_id', $productId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);

        if($stmt->execute()) {
            return "Product added to cart successfully.";
        } else {
            return "Failed to add product to cart.";
        }
    }

    // Function to fetch cart items for a specific user
    public function getCartItems($userId) {
        $sql = "SELECT 
                    c.cart_id, 
                    c.product_id, 
                    p.product_name, 
                    c.quantity, 
                    c.price, 
                    (c.quantity * c.price) AS total_price, 
                    c.date_added
                FROM 
                    cart c
                JOIN 
                    products p ON c.product_id = p.product_id
                WHERE 
                    c.user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
