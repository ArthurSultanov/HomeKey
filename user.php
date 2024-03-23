<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Ultra:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap">
    
    <title>Профиль</title>
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
    padding: 0px;
}

#log a{
    text-align: center;
}

button{
            border-radius: 15px;
background: #056056;
width: 226px;
height: 62px;
flex-shrink: 0;
color: #FFF;

font-family: Ubuntu;
font-size: 24px;
font-style: normal;
font-weight: 700;
line-height: normal;
margin-top: 40%;
        }
</style>
</head>
<body><div><?php include 'header.php'; ?></div>
<div id="container">
<div id="content" style="justify-content: center;">
<div id="log">

<?php

session_start();
 if (isset($_SESSION['username'])) {
    include 'profile.php';
} else {
    // Если не авторизован, показываем форму выбора между регистрацией и входом
    echo '<form method="post" action="">';
      echo'  <h2>Вы не авторизованы! Необходимо авторизоваться</h2><br>';
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
        header("Location: user.php");
        echo '<script>console.log("'.$authKey.','.$userId.'")</script>';
        echo '<script>sessionStorage.setItem("authkey", "' . $authKey . '");</script>';
        exit();
    } else {
        
        echo '<span style="color: red;">Неверное имя пользователя или пароль</span><br>';
    }
}

mysqli_close($dbConnection);


echo '<!-- HTML-форма для входа -->


    <p><input type="text" name="username" placeholder="Логин"></p><br>
    <p><input type="password" name="password" placeholder="Пароль"></p><br>
    <p><input type="submit" value="Войти"></p><br>
    Ещё не зарегистрированы? <a href="reg.php">Зарегистрироваться</a>
</form>';

   
}
?>

</div>
</div>
</div>
</body>
</html>