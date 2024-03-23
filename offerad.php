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
$type = isset($_GET['type']) ? $_GET['type'] : '';
$type_usluga = isset($_GET['type_usluga']) ? $_GET['type_usluga'] : '';
// Проверка, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $usluga = $_POST['usluga'];
    $type_usluga = $_POST['type_usluga'];
    $plata = $_POST['plata'];
    $platainfo = $_POST['platainfo'];
    $addres = $_POST['addres'];
    $description = $_POST['description'];
    $countrooms = $_POST['countrooms'];
    $area = $_POST['area'];

    // SQL-запрос для вставки данных в таблицу Uslugi
    $insertSql = "INSERT INTO Uslugi (usluga, type_usluga, plata, platainfo, addres, description, countrooms, area) VALUES ('$usluga', '$type_usluga', $plata, '$platainfo', '$addres', '$description', $countrooms, $area)";

    if ($conn->query($insertSql) === TRUE) {
        echo "Объявление успешно добавлено!";
    } else {
        echo "Ошибка при добавлении объявления: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление объявления</title>
    <style>
        /* Ваш стиль здесь */
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <h1>Добавить объявление</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Здесь разместите элементы формы для ввода данных -->
        <input type="hidden" name="usluga" value="<?= $type ?>">
    <input type="hidden" name="type_usluga" value="<?= $type_usluga ?>">
    <label for="type">Тип услуги:</label>
        <input type="text" name="type" value="<?= $type ?>" readonly>
        <br>

        <label for="type_usluga">Тип объекта:</label>
        <input type="text" name="type_usluga" value="<?= $type_usluga ?>" readonly>
        <br>
        <br>
        <!-- Остальные элементы формы -->
        <br>
        
        <button type="submit">Добавить объявление</button>
    </form>
</body>
</html>
