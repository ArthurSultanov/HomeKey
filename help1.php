<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        .document-list {
            list-style-type: none;
            padding: 0;
        }

        .document-item {
            margin-bottom: 15px;
        }

        .document-link {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
    <?php include "header.php"?>
    <a href="help.php">Связь с администратором</a>
    <h1>Информация по недвижимости</h1>
    <ul class="document-list">
        <li class="document-item">
            <a href="docs/go_reg.rtf" class="document-link" target="_blank">Федеральный закон от 13 июля 2015 г. N 218-ФЗ
"О государственной регистрации недвижимости"</a>
        </li>
        <li class="document-item">
            <a href="docs/expert_check.pdf" class="document-link" target="_blank">Пример отчета реестра ЕГРН</a>
        </li>
        
        <!-- Добавьте другие документы по аналогии -->
    </ul>
</body>
</html>