<?php
session_start();
include('../includes/db.php');

// Redirect if not logged in as admin
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

// Add product
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $supplier = $_POST['supplier'];
    $qty = $_POST['quantity'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $image = $_POST['image'];

    $conn->query("INSERT INTO Product (ProductName, CategoryId, SupplierId, Quantity, Size, ProductPrice, ProdStatus, Image)
                  VALUES ('$name', $category, $supplier, $qty, '$size', $price, '$status', '$image')");
    $success = "✅ Product added successfully!";
}

// Fetch data
$categories = $conn->query("SELECT * FROM Category");
$suppliers = $conn->query("SELECT * FROM Supplier");
$products = $conn->query("SELECT * FROM Product");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .admin-wrapper {
            max-width: 900px;
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

        form input, form select {
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
    <h2>📦 Manage Products</h2>

    <?php if (isset($success)): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <form method="post">
        <h3>Add New Product</h3>
        <input type="text" name="name" placeholder="Product Name" required>
        <select name="category" required>
            <option value="">-- Select Category --</option>
            <?php while ($c = $categories->fetch_assoc()): ?>
                <option value="<?= $c['CategoryId'] ?>"><?= $c['CategoryName'] ?></option>
            <?php endwhile; ?>
        </select>

        <select name="supplier" required>
            <option value="">-- Select Supplier --</option>
            <?php while ($s = $suppliers->fetch_assoc()): ?>
                <option value="<?= $s['SupplierId'] ?>"><?= $s['SupplierName'] ?></option>
            <?php endwhile; ?>
        </select>

        <input type="number" name="quantity" placeholder="Quantity" required>
        <input type="text" name="size" placeholder="Size (e.g. M, L, XL)" required>
        <input type="number" name="price" placeholder="Price ₹" step="0.01" required>
        <input type="text" name="image" placeholder="Image path (e.g. images/tshirt.jpg)">
        <select name="status" required>
            <option value="Available">Available</option>
            <option value="Out of Stock">Out of Stock</option>
        </select>
        <input type="submit" name="add_product" value="Add Product">
    </form>

    <h3>Existing Products</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Qty</th>
            <th>Size</th>
            <th>Price (₹)</th>
            <th>Status</th>
        </tr>
        <?php while ($p = $products->fetch_assoc()): ?>
        <tr>
            <td><?= $p['ProductId'] ?></td>
            <td><?= $p['ProductName'] ?></td>
            <td><?= $p['Quantity'] ?></td>
            <td><?= $p['Size'] ?></td>
            <td><?= $p['ProductPrice'] ?></td>
            <td><?= $p['ProdStatus'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
