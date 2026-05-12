<?php
require 'partials/dbconnection.php';

$user = $_POST['username'];
$pass = $_POST['password'];

$conn->query("INSERT INTO users (username, password) VALUES ('$user', '$pass')");

header('Location: login.html');
?>