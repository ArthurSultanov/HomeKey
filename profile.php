<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['username'])) {
    include 'login.php';
    exit();
}

// Ваши данные пользователя
$login = $_SESSION['username'];

// Подключение к базе данных
$dbConnection = mysqli_connect("127.0.0.1:3306", "root", "", "HomeKey");

if (!$dbConnection) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Получение данных пользователя из базы данных
$sql = "SELECT * FROM users WHERE login='$login'";
$result = mysqli_query($dbConnection, $sql);

if ($result && $row = mysqli_fetch_assoc($result)) {
    $userId = $row['id_user'];
    $adminLevel = $row['admin_lvl'];
    $username = $row['NameUser'];
    $address = $row['Address'];
    $phone = $row['PhoneNumber'];
    $email = $row['Email'];
    // Дополнительные данные о пользователе, если необходимо
} else {
    echo "Ошибка получения данных пользователя: " . mysqli_error($dbConnection);
}

mysqli_close($dbConnection);
?>

<!-- HTML для отображения информации о пользователе -->
<div>
<h1>Профиль пользователя</h1><br>
<p>Имя пользователя: <?php echo $username; ?></p><br>
<p>Логин: <?php echo $login; ?></p><br>
<p>Адрес: <?php echo $address; ?></p><br>
<p>Номер телефона: <?php echo $phone; ?></p><br>
<p>E-mail: <?php echo $email; ?></p><br>
<div>
<form method="post" action="rewrite.php" >
    <input type="submit" value="Редактировать профиль" style="color:white; background-color: #056056; font-size:large">
    </form>
<form method="post" action="logout.php" >
    <input type="submit" value="Выйти из профиля" style="color:white; background-color: #056056; font-size:large">
    </form>
</div>
</div>


