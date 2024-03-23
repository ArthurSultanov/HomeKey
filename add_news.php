<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить новость</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        form {
            max-width: 600px;
            margin: 20px auto;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php include 'header.php'?>
<?php
session_start();

// Проверка наличия сессии и уровня администратора
if ($admin==false) {
    header("Location: index.php"); // Перенаправление на главную страницу
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Обработка данных формы добавления новости
    $header = $_POST["header"];
    $body = $_POST["body"];

    // Подключение к базе данных (замените на свои данные)
    $servername = "127.0.0.1:3306";
    $username = "root";
    $password = "";
    $dbname = "HomeKey";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Подготовленный запрос для безопасного добавления новости
    $stmt = $conn->prepare("INSERT INTO news (header, body) VALUES (?, ?)");
    $stmt->bind_param("ss", $header, $body);

    // Выполнение запроса
    if ($stmt->execute()) {
        echo "<p>Новость успешно добавлена!</p>";
        header("Location: news.php");
    } else {
        echo "<p>Ошибка при добавлении новости: " . $stmt->error . "</p>";
    }

    // Закрытие соединения
    $stmt->close();
    $conn->close();
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="header">Заголовок новости:</label>
    <input type="text" name="header" required>

    <label for="body">Текст новости:</label>
    <textarea name="body" rows="4" required></textarea>

    <input type="submit" value="Добавить новость">
</form>

</body>
</html>
