<?php
// Подключение к базе данных
$servername = "127.0.0.1:3306"; // Замените на ваш хост, если отличается
$username = "root";
$password = "";
$dbname = "HomeKey";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение IP-адреса посетителя
$ip_address = $_SERVER['REMOTE_ADDR'];

// Проверка, существует ли IP-адрес в базе данных
$sql_check = "SELECT COUNT(*) as ip_count FROM visitors WHERE ip_address = '$ip_address'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    $row_check = $result_check->fetch_assoc();
    $ip_count = $row_check["ip_count"];

    // Если IP-адрес не существует в базе данных, добавляем его
    if ($ip_count == 0) {
        $sql_insert = "INSERT INTO visitors (ip_address) VALUES ('$ip_address')";
        $conn->query($sql_insert);
    }
} else {
    echo "Ошибка при проверке IP-адреса.";
}

// Закрытие соединения
$conn->close();
?>
