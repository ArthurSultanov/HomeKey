<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .find {
            font-family: 'Ubuntu', Arial, sans-serif;
            text-align: left;
            font-size: 120%;
        }

        p {
            margin: 0;
            padding: 3px;
        }
    </style>
    <title>Главная</title>
    <script>
        $(document).ready(function() {
            $("#find").on("click", function() {
                var type = $("#type").val();
                var adType = $("#adType").val();
                var priceFrom = $("#priceOt").val();
                var priceTo = $("#priceDo").val();
                var areaFrom = $("#AreaOt").val();
                var areaTo = $("#areaDo").val();
                var roomFrom = $("#countRoomOt").val();
                var roomTo = $("#countRoomDo").val();
                var address = $("#address").val();

                $.ajax({
                    url: "ads.php",
                    method: "GET",
                    data: {
                        type: type,
                        adType: adType,
                        priceFrom: priceFrom,
                        priceTo: priceTo,
                        areaFrom: areaFrom,
                        areaTo: areaTo,
                        roomFrom: roomFrom,
                        roomTo: roomTo,
                        address: address
                    },
                    success: function(response) {
                        $("#ads-container").html(response);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <span style="font-weight: bold; font-size:14pt; text-align: left;">ПОИСК ОБЪЯВЛЕНИЙ</span><br><br>
    <div class="find">
        <span style="font-weight: bold;">Тип объявления</span>
        <p>
            <select name="type" id="type" style="width:100%;">
            <option value="" selected>Не выбрано</option>
                <option value="Квартира" id="kv">Квартира</option>
                <option value="Дом" id="home">Дом</option>
                <option value="Гараж" id="garage">Гараж</option>
                <option value="Комната" id="room">Комната</option>
                <option value="Участок" id="place">Участок</option>
            </select>
        </p>
        
    </div>
    <div class="find">
        <span style="font-weight: bold;">Вид объявления</span>
        <p>
            <select name="" id="adType" style="width:100%;">
            <option value="" selected>Не выбрано</option>
                <option value="Продажа" id="sell">Продажа</option>
                <option value="Аренда" id="rent">Аренда</option>
                <option value="Покупка" id="buy">Покупка</option>
            </select>
        </p>
    </div>
    <div class="find">
        <span style="font-weight: bold;">Стоимость</span>
        <p>
            от <input type="number" style="width: 36%;" id="priceOt"/> до <input type="number" style="width: 36%;" id="priceDo"/>
        </p>
    </div>
    <div class="find">
        <span style="font-weight: bold;">Площадь</span>
        <p>
            от <input type="number" style="width: 36%;" id="AreaOt"/> до <input type="number" style="width: 36%;" id="areaDo"/>
        </p>
    </div>
    <div class="find">
        <span style="font-weight: bold;">Количество комнат</span>
        <p>
            от <input type="number" style="width: 36%;" id="countRoomOt"/> до <input type="number" style="width: 36%;" id="countRoomDo"/>
        </p>
    </div>
    <div class="find">
        <span style="font-weight: bold;">Адрес</span>
        <p>
            <input type="text" name="" id="" style="width: 100%;" id="address">
        </p>
    </div>
    <button id="find">Найти</button>

    <!-- Контейнер для обновляемого содержимого ads.php -->
    
</body>
</html>
