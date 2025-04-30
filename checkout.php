<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['contact'])) {
    header("Location: login.php");
    exit();
}

$contact = $_SESSION['contact'];
$getCust = $conn->query("SELECT CustId FROM Customer WHERE ContactNo = '$contact'");

if ($getCust && $getCust->num_rows == 1) {
    $custId = $getCust->fetch_assoc()['CustId'];
} else {
    die("Customer not found.");
}

$cartItems = $conn->query("
    SELECT Product.ProductId, Product.ProductPrice, Cart.Quantity
    FROM Cart
    JOIN Product ON Cart.ProductId = Product.ProductId
    WHERE Cart.CustId = $custId
");

$orderAmount = 0;
$items = [];

while ($item = $cartItems->fetch_assoc()) {
    $subtotal = $item['ProductPrice'] * $item['Quantity'];
    $orderAmount += $subtotal;
    $items[] = [
        'productId' => $item['ProductId'],
        'qty' => $item['Quantity']
    ];
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .checkout-success {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #f8fff5;
            border: 2px solid #28a745;
            border-radius: 12px;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .checkout-success h2 {
            color: #28a745;
            font-size: 28px;
        }
        .checkout-success p {
            font-size: 18px;
            margin: 10px 0;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php
if ($orderAmount > 0) {
    // ✅ Create order
    $conn->query("INSERT INTO `Order` (CustId, OrderDate, OrderAmount) VALUES ($custId, NOW(), $orderAmount)");
    $orderNo = $conn->insert_id;

    // ✅ Order details
    foreach ($items as $i) {
        $conn->query("INSERT INTO OrderDetails (OrderNo, ProductId, Quantity)
                      VALUES ($orderNo, {$i['productId']}, {$i['qty']})");
    }

    // ✅ Payment
    $conn->query("INSERT INTO Payment (OrderNo, PaymentDate, PaymentAmount)
                  VALUES ($orderNo, NOW(), $orderAmount)");

    // ✅ Clear cart
    $conn->query("DELETE FROM Cart WHERE CustId = $custId");
?>

<div class="checkout-success">
    <h2>✅ Thank You for Your Order!</h2>
    <p><strong>Order Number:</strong> <?= $orderNo ?></p>
    <p><strong>Total Paid:</strong> ₹<?= number_format($orderAmount, 2) ?></p>
    <a href="index.php" class="back-button">🛍️ Continue Shopping</a>
</div>

<?php
} else {
    echo "<p style='text-align:center; margin-top: 40px;'>🛒 Your cart is empty.</p>";
}
?>

</body>
</html>
