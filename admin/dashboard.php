<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .admin-container {
            max-width: 600px;
            margin: 80px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .admin-container h2 {
            color: #007bff;
            margin-bottom: 30px;
        }

        .admin-btn {
            display: block;
            margin: 15px auto;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            width: 80%;
            transition: background-color 0.3s ease;
        }

        .admin-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="admin-container">
    <h2>Welcome, <?= $_SESSION['admin'] ?> (Admin)</h2>

    <a href="manage_products.php" class="admin-btn">📦 Manage Products</a>
    <a href="manage_categories.php" class="admin-btn">📂 Manage Categories</a>
    <a href="../index.php" class="admin-btn">🏪 View Store</a>
    <a href="logout.php" class="admin-btn" style="background-color: #dc3545;">🚪 Logout</a>
</div>

</body>
</html>
