<?php
session_start();

// Подключение к базе данных
$dbConnection = mysqli_connect("127.0.0.1:3306", "root", "", "HomeKey");

if (!$dbConnection) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

$login = isset($_SESSION['username']) ? $_SESSION['username'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatePhone'])) {
    $newPhone = isset($_POST['newPhone']) ? $_POST['newPhone'] : '';

    // Проверка наличия номера телефона
    if ($newPhone !== "") {
        // Используем параметризованный запрос
        $updateQuery = "UPDATE users SET phonenumber=? WHERE login=?";
        $stmt = mysqli_prepare($dbConnection, $updateQuery);

        // Проверка успешности подготовленного выражения
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $newPhone, $login);

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
        echo "Введите корректный номер телефона.";
    }
}

// Закрытие соединения с базой данных
mysqli_close($dbConnection);
?>
