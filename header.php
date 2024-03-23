<!-- header.php -->
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

    // Получение admin_lvl пользователя
    $admin_lvl = isset($row['admin_lvl']) ? $row['admin_lvl'] : '';
    $_SESSION['id_user'] = isset($row['id_user']) ? $row['id_user'] : '';
    // Проверка на администраторский уровень
    if ($admin_lvl == 1) {
        // Пользователь является администратором
        echo "Администратор";
        $admin=true;
        // Дополнительные действия для администратора
    } else {
        // Пользователь не является администратором
        $admin=false;
        // Дополнительные действия для не-администратора
    }
} else {
    echo '';
}

// Закрытие соединения с базой данных
mysqli_close($dbConnection);
?>

<style>
            nav a {
            position: relative;
            margin-left: 20px;
            text-decoration: none;
            color: #ffffff;
            font-weight: bold;
            border-radius: 5px;
            background: #056056;
            padding: 8px 10px;
            transition: background 0.3s, color 0.3s;
        }

        nav a:hover,
        nav a.active {
            color: #056056;
            background: #ffffff;
        }

        nav a::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 5px;
            background: #ffffff;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }

        nav a.active::after {
            opacity: 0.1;
        }
</style>
<header style="position: sticky;
    top: 0;
    background-color: white;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 1000;
    ">
    <a href="index.php"><img src="logo/LogoSmall.svg<?php echo '?'.uniqid(1); ?>" alt="Company Logo" style="height: 100%;" id="runningLetter"></a>
    
    <nav-container style="position: sticky;
    top: 0;
    background-color: #056056;
    border-radius: 5px;
    padding: 8px;
    z-index: 1000;">
        <nav style="display: flex;">
            <a href="index.php" <?php echo isCurrentPage('index.php') ? 'class="active"' : ''; ?>>Главная</a>
            
            <?php if(!$admin){echo '<a href="about.php"';
            echo isCurrentPage('about.php') ? 'class="active"' : '';
                echo'>О компании</a>';}?>
            <a href="news.php" <?php echo isCurrentPage('news.php') ? 'class="active"' : ''; ?>>Новости</a>
            <?php if(!$admin){echo '<a href="docs.php"';
            echo isCurrentPage('docs.php') ? 'class="active"' : '';
                echo'>Документы</a>';}?>
            <?php if(!$admin){echo '<a href="tariff.php"';
            echo isCurrentPage('tariff.php') ? 'class="active"' : '';
                echo'>Прайс-лист</a>';}?>
            <a href="<?php if ($admin){echo 'adminhelp.php';}else{echo'help1.php';}?>" <?php echo isCurrentPage('help1.php') ? 'class="active"' : ''; ?>><?php if($admin){echo'Чат с пользователем';}else{echo'Справочная';}?></a>
            <?php  ?>
            <a href="user.php" <?php echo isCurrentPage('user.php') ? 'class="active"' : ''; ?>>Профиль</a>
            
        </nav>
    </nav-container>
</header>

<?php
function isCurrentPage($page)
{
    return basename($_SERVER['PHP_SELF']) === $page;
};
?>