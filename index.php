<?php
include('includes/db.php');
session_start();

// Handle add-to-cart from this page
if (isset($_POST['addToCart'])) {
    $productId = (int) $_POST['productId'];
    $quantity = (int) $_POST['quantity'];

    $contact = $_SESSION['contact'] ?? '';
    $custQuery = $conn->query("SELECT CustId FROM Customer WHERE ContactNo = '$contact'");
    if ($custQuery && $custQuery->num_rows === 1) {
        $custId = $custQuery->fetch_assoc()['CustId'];

        $check = $conn->query("SELECT * FROM Cart WHERE CustId = $custId AND ProductId = $productId");
        if ($check->num_rows > 0) {
            $conn->query("UPDATE Cart SET Quantity = Quantity + $quantity WHERE CustId = $custId AND ProductId = $productId");
        } else {
            $conn->query("INSERT INTO Cart (CustId, ProductId, Quantity) VALUES ($custId, $productId, $quantity)");
        }

        $success = "✅ Product added to cart!";
    } else {
        $error = "⚠️ You must be logged in to add items to cart.";
    }
}

// Get category filter before using it
$categoryFilter = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Get list of categories
$categoryList = $conn->query("SELECT * FROM Category");

// Get product list based on selected category
if ($categoryFilter > 0) {
    $products = $conn->query("
        SELECT Product.*, Category.CategoryName 
        FROM Product 
        JOIN Category ON Product.CategoryId = Category.CategoryId 
        WHERE Product.ProdStatus = 'Available' AND Product.CategoryId = $categoryFilter
    ");
} else {
    $products = $conn->query("
        SELECT Product.*, Category.CategoryName 
        FROM Product 
        JOIN Category ON Product.CategoryId = Category.CategoryId 
        WHERE Product.ProdStatus = 'Available'
    ");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Shopping - Home</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            margin: 0;
            background-color: #f5f5f5;
        }

        .navbar {
            background-color: #007bff;
            padding: 15px 30px;
            color: white;
            font-size: 20px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
        }

        .product-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 30px;
        }

        .product-card {
            background-color: white;
            width: 250px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .product-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .product-card p {
            margin: 5px 0;
        }

        .product-card input[type="number"] {
            width: 60px;
            padding: 5px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .product-card button {
            margin-top: 10px;
            background-color: #28a745;
            border: none;
            padding: 10px 20px;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }

        .product-card button:hover {
            background-color: #218838;
        }

        .message {
            text-align: center;
            font-size: 16px;
            color: green;
            margin: 10px 0;
        }

        .error {
            color: red;
        }

        .cart-link {
            text-decoration: none;
            color: white;
            background-color: #ffc107;
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: bold;
        }

        .product-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div>🛍️ Online Shopping</div>
    <div>
        <a href="cart.php" class="cart-link">🛒 View Cart</a>
        <a href="admin/index.php" class="cart-link" style="margin-left: 10px;">👨‍💼 Admin</a>
        <a href="supplier/index.php" class="cart-link" style="margin-left: 20px;">👨‍💼 Supplier</a>
    </div>
</div>

<?php if (isset($success)): ?>
    <p class="message"><?= $success ?></p>
<?php elseif (isset($error)): ?>
    <p class="message error"><?= $error ?></p>
<?php endif; ?>

<form method="GET" style="text-align:center; margin-top: 20px;">
    <label for="category"><strong>Filter by Category:</strong></label>
    <select name="category" id="category" onchange="this.form.submit()" style="padding: 8px; margin-left: 10px;">
        <option value="0">All Categories</option>
        <?php while ($cat = $categoryList->fetch_assoc()): ?>
            <option value="<?= $cat['CategoryId'] ?>" <?= ($categoryFilter == $cat['CategoryId']) ? 'selected' : '' ?>>
                <?= $cat['CategoryName'] ?>
            </option>
        <?php endwhile; ?>
    </select>
</form>

<div class="product-grid">
    <?php while ($row = $products->fetch_assoc()): ?>
        <div class="product-card">
            <img src="<?= $row['Image'] ?>" alt="<?= $row['ProductName'] ?>" class="product-img">
            <h3><?= $row['ProductName'] ?></h3>
            <p>Price: ₹<?= $row['ProductPrice'] ?></p>
            <p>Size: <?= $row['Size'] ?></p>
            <p><strong>Category:</strong> <?= $row['CategoryName'] ?></p>
            <form method="post">
                <input type="hidden" name="productId" value="<?= $row['ProductId'] ?>">
                <input type="number" name="quantity" value="1" min="1">
                <br>
                <button type="submit" name="addToCart">Add to Cart</button>
            </form>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
