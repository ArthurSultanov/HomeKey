<?php
// Подключение к базе данных
$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$dbname = "HomeKey";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchCriteria = json_decode(file_get_contents('php://input'), true);

$sql = "SELECT id_uslugi, usluga, type_usluga, plata, platainfo, addres, description, date, countrooms, area FROM Uslugi WHERE ";
$sql .= buildSearchConditions($searchCriteria);
$sql .= " ORDER BY date DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Получаем данные из строки результата
        $id_uslugi = $row["id_uslugi"];
        $usluga = $row["usluga"];
        $type_usluga = $row["type_usluga"];
        $plata = $row["plata"];
        $platainfo = $row["platainfo"];
        $addres = $row["addres"];
        $description = $row["description"];
        $date = date('d.m.y H:i', strtotime($row["date"]));
        $area = $row["area"];
        $countrooms = $row["countrooms"];

        // Выводим результаты поиска в HTML
        echo '<div class="element-container">';
        echo '<div id="element" data-current-photo="0">';
        
        // Вывод информации о типе объявления
        $bgcolor = ($usluga === 'Аренда') ? "#128510" : (($usluga === "Продажа") ? "#051E60" : "");
        echo '<div class="s-info" style="background-color:' . $bgcolor . '">';
        echo '<span class="s-text">' . $usluga . '</span>';
        echo '</div>';

        // Вывод карусели фотографий
        echo '<div id="photo-container-' . $id_uslugi . '" class="carousel slide" style="width: 345px; height: 230px;">';
        echo '<div class="carousel-inner">';
        // Вывод фотографий
        // ...

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

        // Вывод остальной информации
        echo '<div>';
        echo '<p>' . $type_usluga . '</p>';
        echo '<p><span style="color: #056056;">' . $plata . '</span> ' . $platainfo . '</p>';
        echo '<p>Адрес: ' . $addres . '</p>';
        echo '<p>Площадь: ' . $area . '</p>';
        echo '<p>Количество комнат: ' . $countrooms . '</p>';
        echo '<p>Описание: ' . $description . '</p>';
        echo '<p>' . $date . '</p>';
        // Вывод кнопки "Подробнее" и других дополнительных элементов
        // ...

        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "0 результатов";
}

$conn->close();

function buildSearchConditions($searchCriteria)
{
    $conditions = [];

    foreach ($searchCriteria as $key => $value) {
        if (!empty($value)) {
            switch ($key) {
                case 'priceOt':
                    $conditions[] = "plata >= ?";
                    break;
                case 'priceDo':
                    $conditions[] = "plata <= ?";
                    break;
                case 'areaOt':
                    $conditions[] = "area >= ?";
                    break;
                case 'areaDo':
                    $conditions[] = "area <= ?";
                    break;
                case 'countRoomOt':
                    $conditions[] = "countrooms >= ?";
                    break;
                case 'countRoomDo':
                    $conditions[] = "countrooms <= ?";
                    break;
                case 'address':
                    $conditions[] = "addres LIKE ?";
                    break;
                // Добавьте другие критерии, если необходимо
            }
        }
    }

    return implode(" AND ", $conditions);
}
?>
