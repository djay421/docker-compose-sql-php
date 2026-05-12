<?php
$servername = "mysql";
$username = "root"; //from php.ini
$password = "password"; //from php.ini

try {
    $conn = new mysqli($servername, $username, $password, "users");
    if ($conn->connect_error) {
        error_log($conn->connect_error);
        exit("Connection DB failed");
    }
} catch (Exception $e) {
    error_log($e);
    exit("Connection DB failed");
}

return $conn;
