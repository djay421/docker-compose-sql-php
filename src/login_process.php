<?php
session_start();
$conn = require 'partials/dbconnection.php';

$user = trim($_POST['username'] ?? '');
$pass = $_POST['password'] ?? '';

if ($user === '' || $pass === '') {
    header('Location: login.php?error=1');
    exit;
}

// For demo: accept admin/admin or mechanic/mechanic (plain text, quick prototype)
// In production use password_hash/password_verify
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

// Demo plaintext fallback (since init.sql uses placeholder hash)
// Remove in production and use password_verify($pass, $row['password'])
$validPairs = ['admin' => 'admin', 'mechanic' => 'mechanic'];

if (($row && password_verify($pass, $row['password'])) ||
    (isset($validPairs[$user]) && $validPairs[$user] === $pass)) {
    session_regenerate_id(true);
    $_SESSION['username'] = htmlspecialchars($user);
    header('Location: index.php');
    exit;
} else {
    header('Location: login.php?error=1');
    exit;
}
