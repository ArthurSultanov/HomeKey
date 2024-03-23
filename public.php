<?php
session_start();

$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$dbname = "HomeKey";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получите параметры из GET-запроса, предполагая, что вы передаете параметр id_uslugi
$id_uslugi = isset($_GET['id_uslugi']) ? $_GET['id_uslugi'] : '';

if (!empty($id_uslugi)) {
    // Обновите значение поля published на true
    $updateSql = "UPDATE Uslugi SET published = true WHERE id_uslugi = $id_uslugi";
    
    if ($conn->query($updateSql) === TRUE) {
        echo "Запись успешно опубликована!";
        header("location: index.php");
    } else {
        echo "Ошибка при публикации записи: " . $conn->error;
    }
} else {
    echo "Неверные параметры запроса.";
}

$conn->close();
?>
