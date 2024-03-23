<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Ultra:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap">
    
    <title>Регистрация</title>
    <style>
        body {
    margin: 0;
    padding: 5px;
    font-family: Arial, sans-serif;
    display: flex;
    flex-direction: column;
    overflow-y: scroll;
}
#container {
    display: flex;
    background-color: #056056;
    
}
#content {
    flex: 1;
    padding: 10px;
    height: auto;
    
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    border-radius: 5px;
    background-color: #056056;
    
}

#log {
    position:relative;
    display: flex;
    flex: 1;
    padding: 15px;
    height: auto;
    background-color: #D9D9D9;
    border-radius: 5px;
    align-items: flex-end;
    margin: 0;
    margin-top: 10px;
    font-family: 'Ubuntu', Arial, sans-serif;
    font-size: 1.2vw;
    
}
#log p{
    margin: 0;
    padding: 3px;
}


</style>
</head>
<body>
<?php include 'header.php';?>
<div id="container">
<div id="content" >
<div id="log">
<form method="post" action="">
    <h2>Вы не зарегистрированы! Необходимо зарегистрироваться</h2>
    
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

    // Хеширование пароля
    $hashedPassword = hash('sha256', $password);

    // Вставка пользователя в базу данных
    $sql = "INSERT INTO users (login, password, admin_lvl) VALUES ('$username', '$hashedPassword', 0)";

    if (mysqli_query($dbConnection, $sql)) {
        // Редирект на страницу входа после успешной регистрации
        header("Location: user.php");
        exit();
    } else {
        echo "Ошибка при регистрации: " . mysqli_error($dbConnection);
    }
}

mysqli_close($dbConnection);
?>

<!-- HTML-форма для регистрации -->

    <p><input type="text" name="username" placeholder="Имя пользователя"></p><br>
    <p><input type="password" name="password" placeholder="Пароль"></p><br>
    <p><input type="submit" value="Зарегистрироваться"></p><br>
    Уже есть аккаунт? <a href="user.php">Войти</a>
</form>
</div>
</div>
</div>
</body>
</html>