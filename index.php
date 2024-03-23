<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Ultra:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
    margin: 0;
    padding: 5px;
    font-family: Arial, sans-serif;
    display: flex;
    flex-direction: column;
    
}
footer {
    margin-top: 1%;
    background-color: #000000;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color:#FFFFFF;
    font-family: 'Ubuntu', Arial, sans-serif;
}
#container {
    display: flex;
    margin-top: 10px;
    background-color: #056056;
}
#content {
    flex: 1;
    padding: 10px;
    height: auto;
    background-color: #FFFFFF;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    border-radius: 5px;
    z-index: 0; /* Обеспечивает, чтобы контент находился ниже шапки */
}

#element {
    position: relative;
    display: flex;
    flex: 1;
    padding: 15px;
    height: auto;
    background-color: #D9D9D9;
    border-radius: 5px;
    align-items: flex-start;
    margin: 0;
    margin-top: 10px;
    font-family: 'Ultra', Arial, sans-serif;
}
#element img {
    margin-right: 15px;
    cursor: pointer;
    height: 230px;
}
#element p {
    margin: 0;
    padding: 3px;
}
.details {
    position: absolute;
    bottom: 0;
    right: 0;
    font-size: 12px;
    color: #000000;
}
.details-button {
    background-color: #056056;
    color: #ffffff;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 150%;
}
.details-button,
.details {
    margin-top: 5px; /* Добавляем отступ между "Подробнее" и датой */
}
        #finder {
            
            width: 300px; 
            height: 100vh;
            background-color: #FFFFFF;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            text-align: center; /* Выравнивание текста по центру */
            padding: 10px; /* Внутренний отступ блока */
            border-radius: 5px; /* Добавим скругление углов */
            margin-left: 20px; /* Отступ слева от блока с контентом */
        }
        .s-info {
    position: absolute;
    top: 0;
    right: 0;
    background-color: #128510;
    padding: 5px;
    border-radius: 5px;
}

.s-text {
    color: #ffffff;
    font-weight: bold;
}
.sort-button-1{
    border-radius: 5px;
    stroke: none;
}
.sort-button-1.active{
    background-color: #056056;
    color: #ffffff;
}
.sort-button-2{
    border-radius: 5px;
    stroke: none;
}
.sort-button-2.active{
    background-color: #056056;
    color: #ffffff;
}
.sort-button-3{
    border-radius: 5px;
    stroke: none;
}
.sort-button-3.active{
    background-color: #056056;
    color: #ffffff;
}

    .running-letter {
            
            animation: run 60s infinite linear;
        }
        @keyframes run {
            0% {
                transform: translateX(1vw);
                transform: rotate(10);
            }
            
        }

    </style>
    <title>Главная</title>
</head>
<body>
<?php include 'header.php'; ?>
    <div id="container">
        
        <div id="content">
            <?php 
            
             
            ?>
        <button id="sort-button-1 <?php session_start(); if ($sort=='newest'){echo'.active';}?>" onclick="sortElements('newest')">Сначала новые</button>
<button id="sort-button-2" onclick="sortElements('cheapest')">Сначала дешевые</button>
<button id="sort-button-3" onclick="sortElements('expensive')">Сначала дорогие</button>
<?php if ($admin){echo '<a href="newad.php" class="details-button" style="font-size:small">Добавить объявление</a>';};?>

    <script>
        window.sort;
    function sortElements(sortType) {
        const currentUrl = window.location.href;
        const url = new URL(currentUrl);
        window.sort = sortType;
        url.searchParams.set('sort', sortType);
        
        window.location.href = url.toString();
    }
    
</script>
<div id="ads-container">
        <?php include 'ads.php'; ?>
    </div>
<div id="finder">
<?php include 'finder.php'; ?>
</div>

    </div>
    <footer>
        <div>
            Адрес: ул.Революционная, 13, 2 этаж (комната 208)<br>
    пн-пт 10:00–17:00
<div id="working-hours"></div>

        </div>
<script>
        // Функция для проверки рабочего времени
        function checkWorkingHours() {
            // Получаем текущее время
            var currentTime = new Date();
            console.log(currentTime);
            // Указываем интервал рабочего времени (пн-пт 10:00–17:00)
            var workDayStart = new Date();
            workDayStart.setHours(10, 0, 0); // Пн-Пт, 10:00

            var workDayEnd = new Date();
            workDayEnd.setHours(17, 0, 0); // Пн-Пт, 17:00

            // Проверяем, находится ли текущее время в пределах рабочего времени
            if (currentTime.getDay() >= 1 && currentTime.getDay() <= 5 && currentTime >= workDayStart && currentTime <= workDayEnd) {
                document.getElementById('working-hours').textContent = 'Открыто';
            } else {
                document.getElementById('working-hours').textContent = 'Закрыто';
                document.getElementById('working-hours').classList.add('closed');
            }
        }

        // Вызываем функцию при загрузке страницы
        window.onload = checkWorkingHours;
    </script><br>
<?php include('visit.php'); ?>
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

// Выполнение SQL-запроса для подсчета посетителей
$sql = "SELECT COUNT(*) as total_visitors FROM visitors";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Вывод количества посетителей
    $row = $result->fetch_assoc();
    echo "Количество посетителей: " . $row["total_visitors"];
} else {
    echo "Нет данных о посетителях.";
}

// Закрытие соединения
$conn->close();
?>
</footer>
</body>
</html>
