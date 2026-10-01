<?php
// config.php - database connection only
$host = "localhost";
$user = "root";
$pass = "";
$db   = "laundry_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

// e() = short safe echo, prevents broken layout from quotes/symbols
function e($s) {
    return htmlspecialchars($s ?? "", ENT_QUOTES);
}
?>
