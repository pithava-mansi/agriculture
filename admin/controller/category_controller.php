<?php
// Assuming $conn is your database connection
class CategoryController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addCategory($categoryName) {
        // Check if category already exists
        $query = "SELECT * FROM categories WHERE category_name = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $categoryName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return false; // Category already exists
        }

        // Insert new category
        $query = "INSERT INTO categories (category_name) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $categoryName);
        return $stmt->execute();
    }

    public function updateCategory($categoryId, $categoryName) {
        // Check if category already exists
        $query = "SELECT * FROM categories WHERE category_name = ? AND category_id != ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $categoryName, $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return false; // Category already exists with different ID
        }

        // Update category
        $query = "UPDATE categories SET category_name = ? WHERE category_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $categoryName, $categoryId);
        return $stmt->execute();
    }

    public function deleteCategory($categoryId) {
        $query = "DELETE FROM categories WHERE category_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $categoryId);
        return $stmt->execute();
    }

    public function viewCategories() {
        $query = "SELECT * FROM categories";
        return $this->conn->query($query);
    }
}

// Create a connection and handle form submissions
$conn = new mysqli('localhost', 'root', '', 'Agro');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$categoryController = new CategoryController($conn);

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $categoryName = $_POST['category_name'];
        if ($categoryController->addCategory($categoryName)) {
            header("Location: category.php");
            exit();
        } else {
            $error_message = "Category name already exists. Please choose a different name.";
        }
    } elseif (isset($_POST['update'])) {
        $categoryId = $_POST['category_id'];
        $categoryName = $_POST['category_name'];
        if ($categoryController->updateCategory($categoryId, $categoryName)) {
            header("Location: category.php");
            exit();
        } else {
            $error_message = "Category name already exists or error updating category.";
        }
    } elseif (isset($_POST['delete'])) {
        $categoryId = $_POST['category_id'];
        if ($categoryController->deleteCategory($categoryId)) {
            header("Location: category.php");
            exit();
        } else {
            $error_message = "Error deleting category.";
        }
    }
}
?>
