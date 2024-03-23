<?php
session_start();

// Подключение к базе данных
$dbConnection = mysqli_connect("127.0.0.1:3306", "root", "", "HomeKey");

if (!$dbConnection) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

$login = isset($_SESSION['username']) ? $_SESSION['username'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateUsername'])) {
    $newUsername = isset($_POST['newUsername']) ? $_POST['newUsername'] : '';

    // Проверка наличия имени пользователя
    if ($newUsername !== "") {
        // Используем параметризованный запрос
        $updateQuery = "UPDATE users SET nameuser=? WHERE login=?";
        $stmt = mysqli_prepare($dbConnection, $updateQuery);

        // Проверка успешности подготовленного выражения
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $newUsername, $login);

            // Проверка успешности выполнения запроса
            if (mysqli_stmt_execute($stmt)) {
                echo "Данные успешно сохранены.<br>";
                header("Location: rewrite.php");
            } else {
                echo "Ошибка при выполнении запроса: " . mysqli_error($dbConnection);
            }

            // Закрываем подготовленное выражение
            mysqli_stmt_close($stmt);
        } else {
            echo "Ошибка при подготовке запроса: " . mysqli_error($dbConnection);
        }
    } else {
        echo "Введите корректное имя пользователя.";
    }
}

// Закрытие соединения с базой данных
mysqli_close($dbConnection);
?>
