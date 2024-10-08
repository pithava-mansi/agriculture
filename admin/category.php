<?php
include 'error.php';

session_start();
// Include database connection file
include_once('controller/category_controller.php');
if (!isset($_SESSION['ID'])) {
    include 'logout.php';
    exit();
}
if ($_SESSION['ROLE'] == 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Agrimart - Admin Panel</title>
        <?php include 'css.php'; ?>
        <style>
            /* Glassmorphism styles */
            .glass-card {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.1);
                border-radius: 15px;
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
                padding: 20px;
                margin-bottom: 20px;
                color: #fff;
            }

            .glass-card:hover {
                box-shadow: 0 4px 30px rgba(52, 54, 91, 0.563);
                backdrop-filter: blur(6px);
                -webkit-backdrop-filter: blur(6px);
                border: 2px solid rgba(243, 239, 239, 0.4);
            }

            .glass-table {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
                overflow: hidden;
            }

            .glass-table th,
            .glass-table td {
                background: rgba(255, 255, 255, 0.1);
                color: #ddd;
            }

            .glass-table th {
                backdrop-filter: blur(5px);
                color: #fff;
            }

            .glass-table tbody tr:hover {
                background: rgba(255, 255, 255, 0.2);
            }

            .btn-warning {
                color: #fff;
            }

            .btn-warning:hover {
                background-color: #e0a800;
                border-color: #d39e00;
            }

            .btn-danger {
                color: #fff;
            }

            .btn-danger:hover {
                background-color: #c82333;
                border-color: #bd2130;
            }

            .glass-form {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.1);
                border-radius: 15px;
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
                padding: 20px;
                margin-bottom: 20px;
                color: #fff;
            }

            .glass-form input,
            .glass-form button {
                background: rgba(255, 255, 255, 0.1);
                color: #fff;
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 5px;
                padding: 10px;
                margin-bottom: 10px;
            }

            .glass-form button:hover {
                background-color: #28a745;
                border-color: #218838;
            }
        </style>
    </head>

    <body>
        <?php include 'menu.php'; ?>

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-12">
   <div class="glass-card">
    <h2 class="text-center text-light mb-3">Add Category</h2>
    <div class="glass-form">
        <form action="" method="POST">
            <div class="input-group mb-3">
                <span class="input-group-text mb-2">
                    <h6 class="mb-0">Category</h6>
                </span>
                <input type="text" name="category_name" class="form-control col-8" placeholder="Product Category" required>
                <button type="submit" name="submit" class="btn btn-success col-2">Submit</button>
            </div>
            <?php
            if (isset($error_message)) {
                echo "<div class='alert alert-danger'>{$error_message}</div>";
            }
            ?>
        </form>
    </div>
</div>
                 <div class="glass-card">
                        <h2 class="text-center text-light mb-3">Categories</h2>
                        <div class="table-responsive glass-table">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Category Name</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $data = $categoryController->viewCategories();
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        echo "<tr>
                                            <th scope='row'>{$row['category_id']}</th>
                                            <td>" . htmlspecialchars($row['category_name']) . "</td>
                                            <td>" . htmlspecialchars($row['created_at']) . "</td>
                                            <td>
                                                <form action='#' method='POST'>
                                                    <input type='hidden' value='{$row['category_id']}' name='category_id'>
                                                    <button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#updateCategoryModal' onclick='editCategory({$row['category_id']}, \"{$row['category_name']}\")'><i class='bi bi-pencil-square'></i></button>
                                                    <button class='btn btn-danger btn-sm' type='submit' name='delete' onclick='return confirm(\"Are you sure to delete?\")'><i class='bi bi-trash3'></i></button>
                                                </form>
                                            </td>
                                          </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Category Modal -->
        <div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateCategoryModalLabel">Update Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <input type="hidden" id="update_category_id" name="category_id">
                            <div class="mb-3">
                                <label for="update_category_name" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="update_category_name" name="category_name" required>
                            </div>
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function editCategory(id, name) {
                document.getElementById('update_category_id').value = id;
                document.getElementById('update_category_name').value = name;
            }
        </script>

        <?php include 'js.php'; ?>
    </body>

    </html>
<?php } else {
    include 'logout.php';
}
?>
