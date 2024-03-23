<?php
session_start();


// Проверка наличия параметра id_news в URL
if (!isset($_GET['id_news'])) {
    header("Location: news.php"); // Перенаправление на главную страницу
    exit();
}

$id_news_to_delete = $_GET['id_news'];

// Подключение к базе данных (замените на свои данные)
$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$dbname = "HomeKey";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Подготовленный запрос для удаления новости
$stmt = $conn->prepare("DELETE FROM news WHERE id_news = ?");
$stmt->bind_param("i", $id_news_to_delete);

// Выполнение запроса
if ($stmt->execute()) {
    echo "<p>Новость успешно удалена!</p>";
    header("Location: news.php");
} else {
    echo "<p>Ошибка при удалении новости: " . $stmt->error . "</p>";
}

// Закрытие соединения
$stmt->close();
$conn->close();
?>
