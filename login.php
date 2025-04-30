<?php
include('includes/db.php');

if (isset($_POST['login'])) {
    $contact = $_POST['contact'];

    $sql = "SELECT * FROM Customer WHERE ContactNo = '$contact'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        session_start();
        $_SESSION['contact'] = $contact;
        header("Location: index.php");
    } else {
        echo "Login failed. Invalid contact number.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Shop</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .login-header p {
            color: #666;
            margin: 0;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            border-color: #4a90e2;
            outline: none;
        }
        .login-btn {
            width: 100%;
            padding: 12px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-btn:hover {
            background-color: #3a7bc8;
        }
        .additional-links {
            margin-top: 20px;
            text-align: center;
        }
        .additional-links a {
            color: #4a90e2;
            text-decoration: none;
            font-size: 14px;
        }
        .additional-links a:hover {
            text-decoration: underline;
        }
        .divider {
            margin: 20px 0;
            text-align: center;
            position: relative;
            color: #999;
        }
        .divider::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #eee;
            z-index: -1;
        }
        .divider span {
            background-color: white;
            padding: 0 10px;
        }
        .logo {
            text-align: center;
        }
        .logo img {
            height: 200px;
            width: 200px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <!-- Replace with your logo -->
            <img src="images/onlineshop.jpg" alt="Online Shop Logo">
        </div>
        
        <div class="login-header">
            <h2>Welcome Back</h2>
            <p>Sign in to your account to continue shopping</p>
        </div>
        
        <form method="post" action="login.php">
            <div class="form-group">
                <label for="contact">Phone Number</label>
                <input type="tel" id="contact" name="contact" placeholder="Enter your phone number" required 
                       pattern="[0-9]{10}" title="Please enter a 10-digit phone number">
            </div>
            
            <button type="submit" name="login" class="login-btn">Sign In</button>
            
            <div class="divider"><span>OR</span></div>
            
            <div class="additional-links">
                <a href="register.php">Create an account</a> • 
                <a href="forgot-password.php">Forgot password?</a>
            </div>
        </form>
    </div>
</body>
</html>