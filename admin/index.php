<?php
session_start();
include('../includes/db.php');

if (isset($_POST['login'])) {
    $adminName = $_POST['admin_name'];

    $result = $conn->query("SELECT * FROM Admin WHERE AdminName = '$adminName'");
    if ($result->num_rows === 1) {
        $_SESSION['admin'] = $adminName;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "❌ Invalid admin name.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }

        .login-box {
            max-width: 400px;
            margin: 100px auto;
            padding: 40px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .login-box h2 {
            color: #007bff;
            margin-bottom: 30px;
        }

        .login-box input[type="text"],
        .login-box input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .login-box input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .login-box input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-msg {
            color: red;
            margin-top: 10px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>👨‍💼 Admin Login</h2>

    <?php if (isset($error)): ?>
        <div class="error-msg"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="admin_name" placeholder="Enter Admin Name" required>
        <input type="submit" name="login" value="Login">
    </form>

    <a href="../index.php" class="back-link">← Back to Home</a>
</div>

</body>
</html>
