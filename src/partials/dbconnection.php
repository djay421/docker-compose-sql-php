<?php
$servername = "mysql";
$db_user    = "student";
$db_pass    = "veiligwachtwoord";
$db_name    = "scooterparts";

try {
    $conn = new mysqli($servername, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        error_log($conn->connect_error);
        exit("Connection DB failed");
    }
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    error_log($e);
    exit("Connection DB failed");
}

return $conn;
