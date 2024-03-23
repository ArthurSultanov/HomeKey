<?php
if (!isset($conn)) {
    // Если соединение еще не было создано в admin_chat.php, создаем новое
    $host = '127.0.0.1:3306';
    $username = 'root';
    $password = '';
    $database = 'HomeKey';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}

session_start();

$login = isset($_SESSION['username']) ? $_SESSION['username'] : '';

$sqlSender = "SELECT id_user FROM users WHERE login = '$login'";
$resultSender = $conn->query($sqlSender);

if ($resultSender->num_rows > 0) {
    $rowSender = $resultSender->fetch_assoc();
    $sender_id = $rowSender['id_user'];
} else {
    die("Идентификатор отправителя не найден");
}

$receiver_id = $_GET['receiver_id'];

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

?>

<div style="position: sticky">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="message">Сообщение:</label>
        <input type="text" name="message" id="message">
        <input type="submit" value="Отправить">
    </form>
</div>

<div class="container">
    <div class="chat-box">
        <h2>Чат с <?php echo $receiver_id?></h2>
        <?php getMessages($conn, $sender_id, $receiver_id); ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        function refreshMessages() {
            $.ajax({
                type: "POST",
                url: "get_messages.php",
                data: {
                    sender_id: <?php echo $sender_id; ?>,
                    receiver_id: <?php echo $receiver_id; ?>
                },
                success: function (data) {
                    $(".message-container").html(data);
                }
            });
        }

        setInterval(refreshMessages, 5000);

        $("form").submit(function (e) {
            e.preventDefault();
            var message = $("#message").val();

            $.ajax({
                type: "POST",
                url: "send_message.php",
                data: {
                    sender_id: <?php echo $sender_id; ?>,
                    receiver_id: <?php echo $receiver_id; ?>,
                    message: message
                },
                success: function () {
                    $("#message").val("");
                    refreshMessages();
                }
            });
        });
    });
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST["message"];
    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ($sender_id, $receiver_id, '$message')";
    $conn->query($sql);
}

// Не закрываем соединение здесь, чтобы оставить его открытым для будущих запросов
// $conn->close();
?>