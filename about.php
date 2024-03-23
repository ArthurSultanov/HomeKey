<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О компании</title>
    <style>body {
    margin: 0;
    padding: 5px;
    font-family: Arial, sans-serif;
    display: flex;
    flex-direction: column;
    overflow-y: scroll;
}
div{
    margin: 0;
    padding: 0;
}
div h5{
    padding: 0;
    margin: 0;
}
div ul{
    margin: 1;
    padding: 10;
}
hr{
    width: 10%;
    margin-left:0;
    height: 1px;
    background-color: #056056;
    
}
.map {
           
            display: flex;
            
        }
        .time {
            font-size: 18px;
            color: #FFFFFF;
            text-shadow: white;
            padding: 0;
            
        }
        .closed {
            color: red;
            font-weight: bold;
        }
        .container{
            background-color: #056056;
            padding: 3%;
            color: white;
            text-shadow: white;
            border-radius: 5px;
            margin: 2px;
            font-size: large;
            font-family: 'Ubuntu';
        }
</style>
<link href="https://fonts.googleapis.com/css2?family=Ultra:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap">
</head>
<body>
<?php include 'header.php'; 
?>
<div>
<h3>АГЕНТСТВО НЕДВИЖИМОСТИ “ДОМКЛЮЧ”</h3>
<h5>ВСЕ ВИДЫ УСЛУГ ПО НЕДВИЖИМОСТИ:</h5>
<hr>
<ul>
<li>покупка и продажа недвижимости;</li>
<li>обмены недвижимости любой сложности;</li>
<li>подбор объектов недвижимости; сопровождение,</li>
<li>оформление сделок с недвижимостью; субсидии, материнский капитал, военные сертификаты;</li>
<li>консультации по вопросам в сфере недвижимости бесплатно;</li>
<li>оценка любой недвижимости;</li>
<li>кадастровые услуги (Межевание, снятие и постановка на кадастровый учет и т.д.);</li>
<li>сопровождение сделки купли-продажи недвижимости любой сложности, а также ипотечной сделки DomKlick.</li>
</ul>
<h5>ПРИНЦИПЫ РАБОТЫ С КЛИЕНТАМИ:</h5>
<hr>
<ul>
Для нас очень важно ваше доверие, поэтому мы стремимся соблюдать следующие принципы:
<li>Принцип надежности — Особенности нашей практики является соблюдение законов;</li>
<li>Принцип заботы — с нами клиенты экономят время связанное с вопросами покупки и продажи недвижимости;</li>
<li>Принцип открытости — мы делаем риэлторские услуги доступными и понятными
другие виды юридической помощи</li>
</ul>
</div>
<div style="background-color:#E9E9E9; border-radius: 5px"><h2>Как найти нас?</h2>
<div class="map">

<div style="padding: 10px">
<div class="container">Мы находимся на ул.Революционная, 13, 2 этаж (комната 208)<br></div>
<div class="container">
    <h4 style="margin:0px;">Часы работы</h4><br>
пн-пт 10:00–17:00
<div class="time" id="working-hours" style="margin: 0px;"></div>
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
    </script>
</div>
<div class="container">Так же можете связаться с нами по телефону: +7 (927) 782-20-35,
+7 (932) 858-27-73</div>
<div class="container">
<a href="https://yandex.ru/maps/?source=wizbiz_new_map_single&rtext=~53.650034%2C52.435157&ruri=~ymapsbm1%3A%2F%2Forg%3Foid%3D218547202241&rtt=auto&profile-mode=1&no-distribution=1" style="color: white">Как добраться?</a>
</div>

</div>
<iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d2364.8282811460253!2d52.432582076217216!3d53.65003397237894!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNTPCsDM5JzAwLjEiTiA1MsKwMjYnMDYuNiJF!5e0!3m2!1sru!2sru!4v1702366688136!5m2!1sru!2sru" width="51%" height="400" style="border:1;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>

</div>
</body>
</html>