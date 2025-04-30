<?php
session_start();
include('includes/db.php');

// ✅ Redirect to login if not logged in
if (!isset($_SESSION['contact'])) {
    header("Location: login.php");
    exit();
}

// ✅ Get customer ID using the contact number from session
$contact = $_SESSION['contact'];
$getCust = $conn->query("SELECT CustId FROM Customer WHERE ContactNo = '$contact'");

if ($getCust && $getCust->num_rows == 1) {
    $row = $getCust->fetch_assoc();
    $custId = $row['CustId'];
} else {
    die("Customer not found.");
}

// ✅ Add to cart
if (isset($_POST['addToCart'])) {
    $productId = (int) $_POST['productId'];
    $quantity = (int) $_POST['quantity'];

    // Check if product exists
    $checkProduct = $conn->query("SELECT * FROM Product WHERE ProductId = $productId");
    if ($checkProduct->num_rows == 0) {
        die("Invalid product.");
    }

    // Check if item is already in cart
    $checkCart = $conn->query("SELECT * FROM Cart WHERE CustId = $custId AND ProductId = $productId");
    if ($checkCart->num_rows > 0) {
        $conn->query("UPDATE Cart SET Quantity = Quantity + $quantity WHERE CustId = $custId AND ProductId = $productId");
    } else {
        $conn->query("INSERT INTO Cart (CustId, ProductId, Quantity) VALUES ($custId, $productId, $quantity)");
    }

    // Redirect after action
    header("Location: cart.php");
    exit();
}

if (isset($_GET['add'])) {
    $productId = (int) $_GET['add'];

    // Check if product already in cart
    $check = $conn->query("SELECT * FROM Cart WHERE CustId = $custId AND ProductId = $productId");
    if ($check->num_rows > 0) {
        // Update quantity
        $conn->query("UPDATE Cart SET Quantity = Quantity + 1 WHERE CustId = $custId AND ProductId = $productId");
    } else {
        // Insert new product
        $conn->query("INSERT INTO Cart (CustId, ProductId, Quantity) VALUES ($custId, $productId, 1)");
    }
    header("Location: cart.php");
    exit();
}

// ✅ Remove from cart
if (isset($_GET['remove'])) {
    $productId = (int) $_GET['remove'];
    $conn->query("DELETE FROM Cart WHERE CustId = $custId AND ProductId = $productId");
    header("Location: cart.php");
    exit();
}

// ✅ Fetch cart items
$cartItems = $conn->query("
    SELECT Product.ProductName, Product.ProductPrice, Cart.Quantity, Product.ProductId
    FROM Cart
    JOIN Product ON Cart.ProductId = Product.ProductId
    WHERE Cart.CustId = $custId
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Your Shopping Cart</h2>

    <?php if ($cartItems->num_rows > 0): ?>
    <table border="1">
        <tr>
            <th>Product</th>
            <th>Price (₹)</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
        <?php
        $total = 0;
        while ($item = $cartItems->fetch_assoc()):
            $subtotal = $item['ProductPrice'] * $item['Quantity'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?= $item['ProductName']; ?></td>
            <td>₹<?= $item['ProductPrice']; ?></td>
            <td><?= $item['Quantity']; ?></td>
            <td>₹<?= $subtotal; ?></td>
            <td><a href="cart.php?remove=<?= $item['ProductId']; ?>">Remove</a></td>
        </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="3"><strong>Total</strong></td>
            <td colspan="2"><strong>₹<?= $total; ?></strong></td>
        </tr>
    </table>

    <div class="checkout-button-container">
    <a href="checkout.php" class="checkout-button">✅ Proceed to Checkout</a>
</div>


    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>

</body>
</html>