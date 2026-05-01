<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "evaluation.db";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Error connecting to the database: " . mysqli_connect_error());
}
"Connected successfully!";
?>
