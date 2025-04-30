<?php
session_start();
include('../includes/db.php');

// Ensure that the supplier is logged in
if (!isset($_SESSION['supplier'])) {
    header("Location: index.php");
    exit();
}

$supplierId = $_SESSION['supplier']['SupplierId'];
$supplierName = $_SESSION['supplier']['SupplierName'];

// Fetch products supplied by this supplier
$products = $conn->query("SELECT * FROM Product WHERE SupplierId = $supplierId");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Supplier Dashboard</title>
    <style>
        body {
            background: #f4f4f4;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .dashboard {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .logout {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border-radius: 6px;
        }

        .logout:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="dashboard">
    <h2>👋 Welcome, <?= htmlspecialchars($supplierName) ?></h2>
    <p>Here are the products you're supplying:</p>

    <table>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Size</th>
            <th>Price (₹)</th>
            <th>Status</th>
        </tr>
        <?php while ($p = $products->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($p['ProductName']) ?></td>
            <td><?= htmlspecialchars($p['Quantity']) ?></td>
            <td><?= htmlspecialchars($p['Size']) ?></td>
            <td><?= htmlspecialchars($p['ProductPrice']) ?></td>
            <td><?= htmlspecialchars($p['ProdStatus']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="logout.php" class="logout">🚪 Logout</a>
</div>

</body>
</html>
