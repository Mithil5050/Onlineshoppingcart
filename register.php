<?php
include('includes/db.php');

if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];
    $contact = $_POST['contact'];

    $sql = "INSERT INTO Customer (F_Name, L_Name, Address, City, State, PinCode, ContactNo)
            VALUES ('$fname', '$lname', '$address', '$city', '$state', '$pincode', '$contact')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Online Shop</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Customer Registration</h2>
    <form method="post">
        <input type="text" name="fname" placeholder="First Name" required><br>
        <input type="text" name="lname" placeholder="Last Name" required><br>
        <input type="text" name="address" placeholder="Address" required><br>
        <input type="text" name="city" placeholder="City" required><br>
        <input type="text" name="state" placeholder="State" required><br>
        <input type="text" name="pincode" placeholder="Pincode" required><br>
        <input type="text" name="contact" placeholder="Contact No" required><br>
        <input type="submit" name="register" value="Register">
    </form>
</body>
</html>
