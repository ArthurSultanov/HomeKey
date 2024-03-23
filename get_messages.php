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

function getMessages($conn, $sender_id, $receiver_id) {
    $sql = "SELECT messages.*, 
                   sender.NameUser AS sender_name, 
                   sender.login AS sender_login,
                   receiver.NameUser AS receiver_name,
                   receiver.login AS receiver_login
            FROM messages 
            LEFT JOIN users AS sender ON messages.sender_id = sender.id_user
            LEFT JOIN users AS receiver ON messages.receiver_id = receiver.id_user
            WHERE (messages.sender_id = $sender_id AND messages.receiver_id = $receiver_id) 
               OR (messages.sender_id = $receiver_id AND messages.receiver_id = $sender_id) 
            ORDER BY messages.timestamp ASC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="chat-container">';
        echo '<div class="message-container">';
        
        while($row = $result->fetch_assoc()) {
            $class = ($row['sender_id'] == $sender_id) ? 'sent-message' : 'received-message';
            $formattedTime = date("H:i", strtotime($row['timestamp']));
            $formattedDate = date("Y-m-d", strtotime($row['timestamp']));
           
            echo "<div class='message $class'>";
            echo "{$formattedTime} ";
            
            // Используем NameUser или login в зависимости от доступности
            $senderName = ($row['sender_name'] != null) ? $row['sender_name'] : $row['sender_login'];
            $receiverName = ($row['receiver_name'] != null) ? $row['receiver_name'] : $row['receiver_login'];
            
            echo "<strong>{$senderName}:</strong> {$row['message']}<br>";
            echo "</div>";
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo "<div class='message'>No messages.</div>";
    }
}

getMessages($conn, $sender_id, $receiver_id);
$conn->close();
?>
