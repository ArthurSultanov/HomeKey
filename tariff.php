<?php 
 $servername = "127.0.0.1:3306";
 $username = "root";
 $password = "";
 $dbname = "HomeKey";

 $conn = new mysqli($servername, $username, $password, $dbname);

 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
 $sql = "SELECT * FROM `price_list`;";
 $result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $name = $row["name"];
        $price = $row["price"];
        if ($name=='Дом'){
            $pricehome = $price;
        };
        if ($name=='Квартира'){
            $pricekv = $price;
        };
        if ($name=='Гараж'){
            $pricegarage = $price;
        };
        if ($name=='Участок'){
            $priceplace = $price;
        };
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Ultra:wght@400;700&display=swap" rel="stylesheet">
    <title>Тарифы</title>
    <style>
        body {
    margin: 0;
    padding: 5px;
    font-family: Arial, sans-serif;
    display: flex;
    flex-direction: column;
    overflow-y: scroll;
}
        .bb {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            /* Центрирование по вертикали */
            align-items: center; /* Центрирование по горизонтали */
            height: 100vh; /* Заполнение высоты экрана */
        }

        .ysd {
            display: flex;
            flex-direction: row;
            gap: 1%;
            justify-content: center;
        }

        .el {
            width: 288px;
            height: 355px;
            background-color: #D9D9D9;
            margin-right: 1%;
            color: #056056;

font-family: Ultra;
font-size: 20px;
font-style: normal;
font-weight: 400;
line-height: normal;
text-align: center;
        }
        .el a{
            text-decoration: none;
            color:#D9D9D9;
            background-color: #056056;
            padding: 4px;
            margin: 5px;
            border-radius: 5px;
            font-size: 3vh;
        }
        span{
            color: #000;

font-family: Ultra;
font-size: 24px;
font-style: normal;
font-weight: 400;
line-height: normal;
padding-top: 20%;
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
<body>
    <?php include 'header.php'; ?>
    <div class="bb">
    <h1>Наши услуги</h1>
    <div class="ysd">
    <div class="el">
    <h1>Дом</h1>
    <a href="newad.php?type=Продажа&type_usluga=Дом">Продать</a><br><br>
    <a href="newad.php?type=Покупка&type_usluga=Дом">Купить</a><br><br>
    <a href="newad.php?type=Аренда&type_usluga=Дом">Аренда</a><br><br>
    <span style="font-size:3vh">Стоимость</span><br>
    <?php 
    echo $pricehome;
    ?> рублей
</div>

        <div class="el">
        <h1>Квартира</h1>
        <a href="newad.php?type=Продажа&type_usluga=Квартира">Продать</a><br><br>
    <a href="newad.php?type=Покупка&type_usluga=Квартира">Купить</a><br><br>
    <a href="newad.php?type=Аренда&type_usluga=Квартира">Аренда</a><br><br>
        <span style="font-size:3vh">Стоимость</span><br>
        <?php 
        echo $pricekv;
        ?> рублей
        </div>
        <div class="el">
        <h1>Гараж</h1>
        <a href="newad.php?type=Продажа&type_usluga=Гараж">Продать</a><br><br>
    <a href="newad.php?type=Покупка&type_usluga=Гараж">Купить</a><br><br>
    <a href="newad.php?type=Аренда&type_usluga=Гараж">Аренда</a><br><br>
        <span style="font-size:3vh">Стоимость</span><br>
        <?php 
        echo $pricegarage;
        ?> рублей
        </div>
        <div class="el">
        <h1>Участок</h1>
        <a href="newad.php?type=Продажа&type_usluga=Участок">Продать</a><br><br>
    <a href="newad.php?type=Покупка&type_usluga=Участок">Купить</a><br><br>
    <a href="newad.php?type=Аренда&type_usluga=Участок">Аренда</a><br><br>
        <span style="font-size:3vh">Стоимость</span><br>
        от <?php 
        echo $priceplace;
        ?> рублей
        </div>
    </div>
    <a href="docs/price-list.docx">Скачать прайс-лист</a>
    </div>
    
</body>
</html>
