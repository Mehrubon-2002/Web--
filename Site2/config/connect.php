<?php
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "Service_Samo";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
