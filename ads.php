<?php
session_start();
$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$dbname = "HomeKey";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получите параметры из GET-запроса
$type = isset($_GET['type']) ? $_GET['type'] : '';

$adType = isset($_GET['adType']) ? $_GET['adType'] : '';
$priceFrom = isset($_GET['priceFrom']) ? $_GET['priceFrom'] : '';
$priceTo = isset($_GET['priceTo']) ? $_GET['priceTo'] : '';
$areaFrom = isset($_GET['areaFrom']) ? $_GET['areaFrom'] : '';
$areaTo = isset($_GET['areaTo']) ? $_GET['areaTo'] : '';
$roomFrom = isset($_GET['roomFrom']) ? $_GET['roomFrom'] : '';
$roomTo = isset($_GET['roomTo']) ? $_GET['roomTo'] : '';
$address = isset($_GET['address']) ? $_GET['address'] : '';

// SQL-запрос с учетом параметров фильтрации
$sql = "SELECT id_uslugi, usluga, type_usluga, plata, platainfo, addres, description, date, countrooms, area, published FROM Uslugi WHERE ";
if (!empty($type)) {
    $sql .= "type_usluga = '$type' AND ";
}
if (!empty($adType)) {
    $sql .= "usluga = '$adType' AND ";
}
if (!empty($priceFrom)) {
    $sql .= "plata >= $priceFrom AND ";
}
if (!empty($priceTo)) {
    $sql .= "plata <= $priceTo AND ";
}
if (!empty($areaFrom)) {
    $sql .= "area >= $areaFrom AND ";
}
if (!empty($areaTo)) {
    $sql .= "area <= $areaTo AND ";
}
if (!empty($roomFrom)) {
    $sql .= "countrooms >= $roomFrom AND ";
}
if (!empty($roomTo)) {
    $sql .= "countrooms <= $roomTo AND ";
}
if (!empty($address)) {
    $sql .= "addres LIKE '%$address%' AND ";
}

$sql .= "1"; // Добавляем условие, чтобы всегда была хотя бы одна истина
$sql .= " ORDER BY date DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_uslugi = $row["id_uslugi"];
        $usluga = $row["usluga"];
        $type_usluga = $row["type_usluga"];
        $plata = $row["plata"];
        $platainfo = $row["platainfo"];
        $addres = $row["addres"];
        $description = $row["description"];
        $date = date('d.m.y H:i ', strtotime($row["date"]));
        $area = $row["area"];
        $countrooms = $row["countrooms"];
        $published = $row["published"];
        $photoURLs = [];
        $photoResult = $conn->query("SELECT photo_url FROM photo_uslugi WHERE id_uslugi = $id_uslugi");
        if ($photoResult->num_rows > 0) {
            while ($photoRow = $photoResult->fetch_assoc()) {
                $photoURLs[] = $photoRow["photo_url"];
            }
        } else {
            // Если фотографий нет, добавляем свою картинку ошибки
            $photoURLs[] = "errorim.png";
        }

        
        if ($admin==true || $published==true) {
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
            echo '<span class="s-text">' . $usluga . '</span><br>';
            if ($admin == true) {
                echo '<a href="deletead.php?id_uslugi=' . $id_uslugi . '" style="color:white; background-color:red; border-radius:4px; padding:2px; margin: 2px">Удалить</a>';
            }
            echo '</div>';
    
            // Фиксированный размер для контейнера с каруселью
            echo '<div id="photo-container-' . $id_uslugi . '" class="carousel slide" style="width: 345px; height: 230px;">';
            echo '<div class="carousel-inner">';
            foreach ($photoURLs as $index => $photoURL) {
                $activeClass = ($index === 0) ? 'active' : '';
                echo '<div class="carousel-item ' . $activeClass . '">';
                echo '<img class="photo d-block w-100" style="width: 100%; object-fit: cover;" src="images/elements/' . $photoURL . '" alt="Фото">';
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
            echo '<p><span style="color: #056056;">' . $plata . '</span> ' . $platainfo . '</p>';
            echo '<p>Адрес: ' . $addres . '</p>';
            echo '<p>Площадь: ' . $area . '</p>';
            echo '<p>Количество комнат: ' . $countrooms . '</p>';
            echo '<p>Описание: ' . $description . '</p>';
            
            echo '<p>' . $date . '</p><div>';
            if($published==false){
                echo '<a href="public.php?id_uslugi=' . $id_uslugi . '">Опубликовать</a>';
            };
            if ($admin && $published){
                echo '<a href="bublic.php">Снять с публикации</a>';
            }
            echo '</div><div class="details">';
            echo '<div><a href="click.php?id_uslugi=' . $id_uslugi . '" class="details-button">ЗАЯВКА</a></div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
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