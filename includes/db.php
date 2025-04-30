<?php
$host = "localhost";
$user = "root"; // default username for XAMPP/WAMP
$password = "root"; // leave empty unless you set one
$database = "onlineshop";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
