<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администраторский чат</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .chat-box {
            background-color: #fff;
            border: 1px solid #ddd;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .message-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .chat-container {
        max-height: 45vh; /* Установите желаемую максимальную высоту контейнера */
        overflow-y: auto;
    }

        .message {
            padding: 8px;
            border-radius: 5px;
            max-width: 70%; /* Adjust as needed */
        }

        .sent-message {
            background-color: #0088cc;
            color: #fff;
            align-self: flex-end;
            text-align: right;
        }

        .received-message {
            background-color: #e0e0e0;
            color: #000;
            align-self: flex-start;
            text-align: left;
        }

        .message strong {
            color: #0088cc;
        }

        form {
            display: flex;
            margin-top: 10px;
        }

        form input[type="text"] {
            flex-grow: 1;
            padding: 8px;
        }

        form input[type="submit"] {
            background-color: #0088cc;
            color: #fff;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php
    $host = '127.0.0.1:3306';
    $username = 'root';
    $password = '';
    $database = 'HomeKey';

    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    session_start();

    $login = isset($_SESSION['username']) ? $_SESSION['username'] : '';

    $sqlUsersList = "SELECT id_user, login FROM users";
    $resultUsersList = $conn->query($sqlUsersList);

    if ($resultUsersList->num_rows > 0) {
        echo "<h2>Выберите пользователя:</h2>";
        echo "<ul>";
        while ($rowUser = $resultUsersList->fetch_assoc()) {
            echo "<li><a href='adminhelp.php?receiver_id={$rowUser['id_user']}'>{$rowUser['id_user']} {$rowUser['login']}</a></li>";
        }
        echo "</ul>";

        if (isset($_GET['receiver_id'])) {
            $receiver_id = $_GET['receiver_id'];
            include 'chat.php';
        }
    } else {
        echo "Нет зарегистрированных пользователей.";
    }

    $conn->close(); // Закрываем соединение после использования
    ?>
</body>
</html>
