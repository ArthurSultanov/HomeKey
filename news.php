<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новости</title>
    <style>
        body {
    margin: 0;
    padding: 5px;
    font-family: Arial, sans-serif;
    display: flex;
    flex-direction: column;
    overflow-y: scroll;
}

#content {
    background-color: #056056;
    display: flex;
    flex-wrap: wrap;  /* Позволяет обертывать элементы в новую строку */
    justify-content: space-around;  /* Распределяет элементы вокруг */
}

#container {
    background-color: #d9d9d9;
    width: 48%;  /* Ширина каждого контейнера, чтобы вместить два на одной строке */
    margin: 1%;
    box-sizing: border-box;  /* Учитывает границы и отступы в ширине */
}

</style>
</head>
<body>
<?php include 'header.php'; ?>
<?php if ($admin==true) {
    
    echo '<div id="admin-links">';
    echo '<a href="add_news.php" style="color:white; background-color:green; border-radius:4px; padding:2px; margin: 2px; text-decoration:none">Добавить новость</a>';
    echo '</div>';
} ?>
<div id="content">
<?php
// Начать или продолжить сеанс
session_start();

$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$dbname = "HomeKey";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Проверить, вошел ли пользователь в систему и имеет ли необходимый уровень администратора


$sql = "SELECT id_news, header, body, datenews FROM news";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_news = $row["id_news"];
        $header = $row["header"];
        $body = $row["body"];
        $datenews = $row["datenews"];

        // Динамическое создание HTML для каждой новости
        echo '<div id="container" style="padding: 10px;">';
        echo '<h3 style="margin-bottom: 8px;">' . $header . '</h3>';
        echo '<p style="margin-bottom: 8px;">' . $body . '</p>';
        echo '<p>' . $datenews . '</p>';
        if ($admin==true){
        echo '<a href="delete_news.php?id_news=' . $id_news . '" style="color:white; background-color:red; border-radius:4px; padding:2px; margin: 2px; text-decoration:none">Удалить</a>';
        }
        echo '</div>';
    }
}

$conn->close();
?>

    
</div>

</body>
</html>