<?php
$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$dbname = "HomeKey";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$filters = $_GET['filters'];
$type_usluga_conditions = $filters['type_usluga'];

$conditions = [];
if (!empty($type_usluga_conditions)) {
    $conditions[] = "type_usluga IN ('" . implode("','", $type_usluga_conditions) . "')";
}

$sort = $_GET['sort'];

if (isset($_GET['kv'])) {
    $conditions[] = "type_usluga='Квартира'";
}

$sql = "SELECT id_uslugi, usluga, type_usluga, plata, addres, description, date, countrooms, area FROM Uslugi";

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

switch ($sort) {
    case 'cheapest':
        $sql .= " ORDER BY plata ASC";
        break;
    case 'expensive':
        $sql .= " ORDER BY plata DESC";
        break;
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
            $photoURLs[] = "images/errorim.png";
        }

        echo '<div class="element-container">';
        echo '<div id="element" data-current-photo="0">';
        if ($usluga === 'Аренда') {
            $bgcolor = "#128510";
        } else {
            if ($usluga === "Продажа") {
                $bgcolor = "#051E60";
            }
        };
        echo '<div class="s-info" style="background-color:' . $bgcolor . '">';
        echo '<span class="s-text">' . $usluga . '</span>';
        echo '</div>';

        echo '<div id="photo-container-' . $id_uslugi . '" class="carousel slide">';
        echo '<div class="carousel-inner">';
        foreach ($photoURLs as $index => $photoURL) {
            $activeClass = ($index === 0) ? 'active' : '';
            echo '<div class="carousel-item ' . $activeClass . '">';
            echo '<img class="photo d-block w-100" src="images/elements/' . $photoURL . '.png" alt="Фото">';
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
