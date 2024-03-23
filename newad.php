<?php
// Подключение к базе данных
session_start();
try {
    $pdo = new PDO('mysql:host=127.0.0.1:3306;dbname=HomeKey', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
    die();
}
$type = isset($_GET['type']) ? $_GET['type'] : '';
$type_usluga = isset($_GET['type_usluga']) ? $_GET['type_usluga'] : '';
// Обработка отправленной формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Подготовка SQL-запроса для добавления записи в таблицу uslugi
        $sql_uslugi = "INSERT INTO uslugi (usluga, type_usluga, plata, platainfo, addres, description, area, countrooms, date, published, id_user) 
                VALUES (:usluga, :type_usluga, :plata, :platainfo, :addres, :description, :area, :countrooms, NOW(), :published, :id_user)";
if ($_POST['usluga']=='Продажа'){
    $platainfo = 'рублей';
} else {
    if ($_POST['usluga']=='Аренда'){
        $platainfo = 'рублей/месяц';
    } else {
        $platainfo = 'рублей';
    }
};
// Подготовка данных для вставки
$data = array(
    'usluga' => $_POST['usluga'],
    'type_usluga' => $_POST['type_usluga'],
    'plata' => $_POST['plata'],
    'platainfo' => $platainfo,
    'addres' => $_POST['addres'],
    'description' => $_POST['description'],
    'area' => $_POST['area'],
    'countrooms' => $_POST['countrooms'],
    'published' => '0',
    'id_user' => $_SESSION['id_user']
    // Добавьте остальные поля и их значения
);

        // Подготовка и выполнение запроса для вставки в таблицу uslugi
        $stmt_uslugi = $pdo->prepare($sql_uslugi);
        $stmt_uslugi->execute($data); 

        // Получение ID только что добавленной записи
        $id_uslugi = $pdo->lastInsertId();

        // Загрузка фотографий
        $max_photos = 4;
        for ($i = 1; $i <= $max_photos; $i++) {
            $input_name = "photo{$i}";

            // Проверка, был ли выбран файл
            if (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] === UPLOAD_ERR_OK) {
                $photo_extension = pathinfo($_FILES[$input_name]['name'], PATHINFO_EXTENSION);
                $photo_url = '' .$id_uslugi.$i. '.' . $photo_extension;

                // Перемещение файла в директорию
                move_uploaded_file($_FILES[$input_name]['tmp_name'], 'images/elements/'.$photo_url);

                // Подготовка SQL-запроса для добавления фотографии в таблицу photos
                $sql_photos = "INSERT INTO photo_uslugi (id_uslugi, photo_url) VALUES (:id_uslugi, :photo_url)";

                // Подготовка данных для вставки в таблицу photos
                $data_photos = array(
                    'id_uslugi' => $id_uslugi,
                    'photo_url' => $photo_url
                );

                // Подготовка и выполнение запроса для вставки в таблицу photos
                $stmt_photos = $pdo->prepare($sql_photos);
                $stmt_photos->execute($data_photos);
            }
        }

        echo "Данные успешно добавлены в таблицу uslugi и фотографии загружены.";
        header('location: index.php');
    } catch (PDOException $e) {
        echo "Ошибка при добавлении данных: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 5px;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            overflow-y: scroll;
        }

        #container {
            display: flex;
            background-color: #056056;
        }

        #content {
            flex: 1;
            padding: 10px;
            height: auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            border-radius: 5px;
            background-color: #056056;
        }

        #log {
            position: relative;
            display: flex;
            flex: 1;
            padding: 15px;
            height: auto;
            background-color: #D9D9D9;
            border-radius: 5px;
            align-items: flex-end;
            margin: 0;
            margin-top: 10px;
            font-family: 'Ubuntu', Arial, sans-serif;
            font-size: 1.2vw;
        }

        #log p {
            margin: 0;
            padding: 3px;
        }
        .lefttd{
            text-align: right;
        }
    </style>
</head>
<body>
    <?php include 'header.php'?>
    <div class="container">
        <div class="content">
            <h2>Создание объявления</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <!-- Остальные поля формы остаются без изменений -->
                <table style="font-size:2.5vh">
                    <tr>
                        <td class="lefttd">
                <label for="usluga">Тип услуги:</label>
                        </td>
                        <td>
                            <?php if($admin){
                                echo'<select name="usluga" id="usluga" style="width:15vw;height:4vh;font-size:2.5vh">
                                <option value="Продажа">Продажа</option>
                                <option value="Аренда">Аренда</option>
                                <option value="Покупка">Покупка</option>
                            </select><br>';
                            }else{
                                echo '<input type="text" name="usluga" value="' .$type.'" readonly>';
                            } ?>
                
                  </td>
                </tr>
                <tr>
                    <td class="lefttd">
                        <label for="type_usluga">Имущество:</label>
                    </td>
                    <td>
                        <?php if($admin){
                            echo '<select name="type_usluga" id="type_usluga" style="width:15vw;height:4vh;font-size:2.5vh">
                            <option value="Квартира">Квартира</option>
                            <option value="Дом">Дом</option>
                            <option value="Гараж">Гараж</option>
                            <option value="Комната">Комната</option>
                            <option value="Участок">Участок</option>
                            </select><br>';
                        }else{ echo '<input type="text" name="type_usluga" value="'. $type_usluga. '" readonly>';}?>
                    
                    </td>
                </tr>
                <tr>
                    <td class="lefttd">
                    <label for="plata">Плата:</label>
                    </td>
                    <td>
                    <input type="number" name="plata" required style="width:14.5vw;height:3.5vh;font-size:2.5vh"><br>
                    </td>
                </tr>
                <tr>
                    <td class="lefttd">
                    <label for="addres">Адрес:</label>
                    </td>
                    <td>
                    <input type="text" name="addres" required style="width:14.5vw;height:3.5vh;font-size:2.5vh"><br>
                    </td>
                </tr>
                <tr>
                    <td class="lefttd">
                    <label for="description">Описание:</label>
                    </td>
                    <td>
                    <textarea name="description" required style="width:14.5vw;height:15vh;font-size:2.5vh"></textarea><br>
                    </td>
                </tr>
                <tr>
                    <td class="lefttd">
                    <label for="area">Площадь:</label>
                    </td>
                    <td>
                    <input type="text" name="area" required style="width:14.5vw;height:3.5vh;font-size:2.5vh"><br>
                    </td>
                </tr>
                <tr>
                    <td class="lefttd">
                    <label for="countrooms">Количество комнат:</label>
                    </td>
                    <td>
                    <input type="number" name="countrooms" required style="width:14.5vw;height:3.5vh;font-size:2.5vh"><br>
                    </td>
                </tr>
                
                
                <tr>
                    <td class="lefttd"><label for="photo1">Фотография 1:</label></td>
                    <td>
                    
                <input type="file" name="photo1"><br>

                    </td>
                </tr>
                <tr>
                    <td class="lefttd"><label for="photo2">Фотография 2:</label></td>
                    <td><input type="file" name="photo2"><br></td>
                </tr>
                <tr>
                    <td class="lefttd">
                        <label for="photo3">Фотография 3:</label>
                    </td>
                    <td >
                        <input type="file" name="photo3"><br>
                    </td>
                </tr>
                <tr>
                    <td class="lefttd">
                    <label for="photo4">Фотография 4:</label>
                    </td>
                    <td><input type="file" name="photo4"><br></td>
                </tr>
                <tr><td></td></tr>
                <tr colspan="2">
                    <td>
                    
                    </td>
                    <td>
                    <input type="submit" value="Создать объявление" style="border-radius:5px; background-color: #056056;color:white; border-color:#D9D9D9; height:5vh; font-size:3vh">
                    </td>
                </tr>
                
                </table>
            </form>
        </div>
    </div>
</body>
</html>
