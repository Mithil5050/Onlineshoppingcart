<?php
session_start();
include('../includes/db.php');

if (isset($_POST['login'])) {
    $name = $_POST['supplier_name'];

    $result = $conn->query("SELECT * FROM Supplier WHERE SupplierName = '$name'");

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc(); // ✅ Fetch the row
        $_SESSION['supplier'] = $row;  // ✅ Store the full row in session
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "❌ Login failed! Supplier not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Supplier Login</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            padding-top: 50px;
        }

        .login-box {
            width: 350px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        a {
            display: block;
            margin-top: 15px;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>👷 Supplier Login</h2>
    
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="supplier_name" placeholder="Supplier Name" required>
        <input type="submit" name="login" value="Login">
    </form>

    <a href="../index.php">← Back to Store</a>
</div>

</body>
</html>
