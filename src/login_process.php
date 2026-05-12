<?php
session_start();
require 'partials/dbconnection.php';

$user = $_POST['username'];
$pass = $_POST['password'];

$result = $conn->query("SELECT * FROM users WHERE username='$user' AND password='$pass'");

if ($result->num_rows > 0) {
    $_SESSION['username'] = $user;
    header('Location: index.php');
} else {
    $_SESSION['error'] = 'Invalid login';
    header('Location: login.html');
}
?>