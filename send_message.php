<?php
session_start();

$host = '127.0.0.1:3306';
$username = 'root';
$password = '';
$database = 'HomeKey';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];
$message = $_POST['message'];

$sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ($sender_id, $receiver_id, '$message')";
$conn->query($sql);

$conn->close();
?>
