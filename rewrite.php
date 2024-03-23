<!DOCTYPE html>
<?php
session_start();

$dbConnection = mysqli_connect("127.0.0.1:3306", "root", "", "HomeKey");

if (!$dbConnection) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

$login = isset($_SESSION['username']) ? $_SESSION['username'] : '';

$sql = "SELECT * FROM users WHERE login='$login'";
$result = mysqli_query($dbConnection, $sql);

if ($result && $row = mysqli_fetch_assoc($result)) {
    $username = isset($row['NameUser']) ? $row['NameUser'] : '';
    $address = isset($row['Address']) ? $row['Address'] : '';
    $phone = isset($row['PhoneNumber']) ? $row['PhoneNumber'] : '';
    $email = isset($row['Email']) ? $row['Email'] : '';
} else {
    echo "Ошибка получения данных пользователя: " . mysqli_error($dbConnection);
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Ultra:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap">
    
    <title>Профиль</title>
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
            flex-direction: column;
            padding: 15px;
            height: auto;
            background-color: #D9D9D9;
            border-radius: 5px;
            align-items: flex-start;
            margin: 0;
            margin-top: 10px;
            font-family: 'Ubuntu', Arial, sans-serif;
            font-size: 1.1vw;
        }

        #log p {
            margin: 0;
            padding: 0px;
        }

        #log a {
            text-align: center;
        }

        /* Оформление форм */
        form {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
            align-items: flex-start;
        }

        label {
            margin-bottom: 5px;
        }

        input {
            padding: 5px;
            margin-bottom: 10px;
        }

        button {
            padding: 8px;
            cursor: pointer;
            color:white; background-color: #056056; font-size:large
        }
    </style>
</head>
<body>
    <div><?php include 'header.php'; ?></div>
    <div id="container">
        <div id="content" style="justify-content: center;">
            <div id="log">
                <!-- Форма для обновления имени пользователя -->
                <form method="post" action="newname.php">
                    <label for="newUsername">Новое имя пользователя:</label>
                    <input type="text" name="newUsername" id="newUsername" value="<?php echo $username; ?>">
                    <button type="submit" name="updateUsername">Сохранить</button>
                </form>

                <!-- Форма для обновления адреса -->
                <form method="post" action="newaddress.php">
                    <label for="newAddress">Новый адрес:</label>
                    <input type="text" name="newAddress" id="newAddress" value="<?php echo $address; ?>">
                    <button type="submit" name="updateAddress">Сохранить</button>
                </form>

                <!-- Форма для обновления телефона -->
                <form method="post" action="newphone.php">
                    <label for="newPhone">Новый номер телефона:</label>
                    <input type="tel" name="newPhone" id="newPhone" value="<?php echo $phone; ?>">
                    <button type="submit" name="updatePhone">Сохранить</button>
                </form>

                <!-- Форма для обновления электронной почты -->
                <form method="post" action="newemail.php">
                    <label for="newEmail">Новый адрес электронной почты:</label>
                    <input type="text" name="newEmail" id="newEmail" value="<?php echo $email; ?>">
                    <button type="submit" name="updateEmail">Сохранить</button>
                </form>

                <?php
                function performUpdate($query)
                {
                    global $dbConnection;

                    if (mysqli_query($dbConnection, $query)) {
                        echo "Данные успешно сохранены.";
                    } else {
                        echo "Ошибка при сохранении данных: " . mysqli_error($dbConnection);
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Закрытие соединения с базой данных
mysqli_close($dbConnection);
?>
