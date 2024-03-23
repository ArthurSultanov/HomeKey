<?php
session_start();



// Проверка наличия параметра id_uslugi в URL
if (!isset($_GET['id_uslugi'])) {
    header("Location: index.php"); // Перенаправление на главную страницу
    exit();
}

$id_uslugi_to_delete = $_GET['id_uslugi'];

// Подключение к базе данных (замените на свои данные)
$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$dbname = "HomeKey";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Подготовленный запрос для удаления связанных фотографий
$photoDeleteStmt = $conn->prepare("DELETE FROM photo_uslugi WHERE id_uslugi = ?");
$photoDeleteStmt->bind_param("i", $id_uslugi_to_delete);

// Выполнение запроса
$photoDeleteStmt->execute();
$photoDeleteStmt->close();

// Теперь подготовленный запрос для удаления объявления
$stmt = $conn->prepare("DELETE FROM Uslugi WHERE id_uslugi = ?");
$stmt->bind_param("i", $id_uslugi_to_delete);

// Выполнение запроса
if ($stmt->execute()) {
    echo "<p>Объявление успешно удалено!</p>";
    header("Location: index.php");
} else {
    echo "<p>Ошибка при удалении объявления: " . $stmt->error . "</p>";
}

// Закрытие соединения
$stmt->close();
$conn->close();
?>
