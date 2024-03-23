<?php
session_start();

// Подключение к базе данных
$dbConnection = mysqli_connect("127.0.0.1:3306", "root", "", "HomeKey");

if (!$dbConnection) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Хеширование введенного пароля
    $hashedPassword = hash('sha256', $password);

    // Проверка учетных данных в базе данных
    $sql = "SELECT * FROM users WHERE login='$username' AND password='$hashedPassword'";
    $result = mysqli_query($dbConnection, $sql);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        // Генерация authkey
        $authKey = bin2hex(random_bytes(32));

        // Обновление authkey в базе данных
        $userId = $row['id_user'];
        $updateSql = "UPDATE users SET authkey='$authKey' WHERE id_user=$userId";
        mysqli_query($dbConnection, $updateSql);
        
        // Сохранение authkey в сессии и в session storage
        $_SESSION['username'] = $username;
        $_SESSION['authkey'] = $authKey;
        
        

        // Перенаправление на страницу профиля
        
        echo '<script>console.log("'.$authKey.','.$userId.'")</script>';
        echo '<script>sessionStorage.setItem("authkey", "' . $authKey . '");</script>';
        exit();
    } else {
        echo "Неверное имя пользователя или пароль";
    }
}

mysqli_close($dbConnection);
?>

<!-- HTML-форма для входа -->
<form method="post" action="">
    <input type="text" name="username" placeholder="Имя пользователя">
    <input type="password" name="password" placeholder="Пароль">
    <input type="submit" value="Войти">
</form>
