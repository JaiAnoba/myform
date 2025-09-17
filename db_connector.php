<?php
$host = getenv("DB_HOST");
$username = getenv("DB_USERNAME");
$password = getenv("DB_PASSWORD");
$database = getenv("DB_DATABASE");

// Connect
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
