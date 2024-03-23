<?php
session_start();
echo '<script>sessionStorage.clear</script>';
// Разрушение сессии
session_destroy();

// Перенаправление на страницу входа
header('location: user.php');
exit();
?>
