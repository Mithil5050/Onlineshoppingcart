<?php
session_start();
include('../includes/db.php');

// Redirect if not logged in as admin
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

// Add new category
if (isset($_POST['add_category'])) {
    $name = $_POST['name'];
    $conn->query("INSERT INTO Category (CategoryName) VALUES ('$name')");
    $success = "✅ Category added successfully!";
}

// Get all categories
$categories = $conn->query("SELECT * FROM Category");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Categories</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .admin-wrapper {
            max-width: 700px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #007bff;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            margin-bottom: 40px;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        form input[type="submit"] {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .success {
            color: green;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <h2>📂 Manage Categories</h2>

    <?php if (isset($success)): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <form method="post">
        <h3>Add New Category</h3>
        <input type="text" name="name" placeholder="Category Name" required>
        <input type="submit" name="add_category" value="Add Category">
    </form>

    <h3>Existing Categories</h3>
    <table>
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
        </tr>
        <?php while ($c = $categories->fetch_assoc()): ?>
        <tr>
            <td><?= $c['CategoryId'] ?></td>
            <td><?= $c['CategoryName'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
