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
        <?php
            $servername = "127.0.0.1:3306";
            $username = "root";
            $password = "";
            $dbname = "HomeKey";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
            $kv = $_GET['kv'];
            if (isset($kv)){ $sql = "SELECT id_uslugi, usluga, type_usluga, plata, addres, description, date, countrooms, area FROM Uslugi where type_usluga='Квартира'";}
           else{
            $sql = "SELECT id_uslugi, usluga, type_usluga, plata, addres, description, date, countrooms, area FROM Uslugi";
           }
            switch ($sort) {
                case 'cheapest':
                    $sql .= " ORDER BY plata ASC";
                    
                    break;
                case 'expensive':
                    $sql .= " ORDER BY plata DESC";
                    break;
                // Добавьте другие варианты сортировки по мере необходимости
                default:
                    $sql .= " ORDER BY date DESC";
                    break;
            }
            
           
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id_uslugi = $row["id_uslugi"];
                    $usluga = $row["usluga"];
                    $type_usluga = $row["type_usluga"];
                    $plata = $row["plata"];
                    $addres = $row["addres"];
                    $description = $row["description"];
                    $date = $row["date"];
                    $area = $row["area"];
                    $countrooms = $row["countrooms"];

                    $photoURLs = [];
                    $photoResult = $conn->query("SELECT photo_url FROM photo_uslugi WHERE id_uslugi = $id_uslugi");
                    if ($photoResult->num_rows > 0) {
                        while ($photoRow = $photoResult->fetch_assoc()) {
                            $photoURLs[] = $photoRow["photo_url"];
                        }
                    } else {
                        // Если фотографий нет, добавляем свою картинку ошибки
                        $photoURLs[] = "images/errorim.png";
                    }

                    echo '<div class="element-container">';
                    echo '<div id="element" data-current-photo="0">';
                    if ($usluga === 'Аренда'){
                        $bgcolor = "#128510";
                    } else {
                        if ($usluga === "Продажа"){
                            $bgcolor = "#051E60";
                        }
                    };
                    echo '<div class="s-info" style="background-color:'.$bgcolor.'">';
                    
                    echo '<span class="s-text">' . $usluga . '</span>';
                    echo '</div>';
                    
                    // Фиксированный размер для контейнера с каруселью
                    echo '<div id="photo-container-' . $id_uslugi . '" class="carousel slide" style="width: 345px; height: 230px;">';
                    echo '<div class="carousel-inner">';
                    foreach ($photoURLs as $index => $photoURL) {
                        $activeClass = ($index === 0) ? 'active' : '';
                        echo '<div class="carousel-item ' . $activeClass . '">';
                        echo '<img class="photo d-block w-100" style="width: 100%; object-fit: cover;" src="images/elements/' . $photoURL . '.png" alt="Фото">';
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '<a class="carousel-control-prev" href="#photo-container-' . $id_uslugi . '" role="button" data-slide="prev">';
                    echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                    echo '<span class="sr-only">Previous</span>';
                    echo '</a>';
                    echo '<a class="carousel-control-next" href="#photo-container-' . $id_uslugi . '" role="button" data-slide="next">';
                    echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                    echo '<span class="sr-only">Next</span>';
                    echo '</a>';
                    echo '</div>';
                    
                    // Остальной текст
                    echo '<div>';
                    echo '<p>' . $type_usluga . '</p>';
                    echo '<p><span style="color: #056056;">' . $plata . '</span> рублей/месяц</p>';
                    echo '<p>Адрес: ' . $addres . '</p>';
                    echo '<p>Площадь: ' . $area . '</p>';
                    echo '<p>Количество комнат: ' . $countrooms . '</p>';
                    echo '<p>Описание: ' . $description . '</p>';
                    echo '<div class="details">';
                    echo '<div><button class="details-button">Подробнее</button></div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "0 результатов";
            }

            $conn->close();
            ?>

        </div>
        
        <script>
    $(document).ready(function(){
        // Инициализация карусели для каждого элемента
        <?php
        foreach ($result->fetch_assoc() as $row) {
            $id_uslugi = $row["id_uslugi"];
            echo '$("#photo-container-' . $id_uslugi . '").carousel({ interval: false });'; // Установим interval: false для отключения автоматического листания
        }
        ?>
    });
</script>


        
       
    </div>
    <footer>
Здесь будет контактная информация
</footer>
</body>
</html>
