<?php
$host = '127.0.0.1:3306';
$username = 'root';
$password = '';
$database = 'HomeKey';
session_start();

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
