<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваши документы</title>
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
    <?php include 'header.php'?>
    <h1>Типовые договора</h1>
    <ul class="document-list">
        <li class="document-item">
            <a href="docs/dogovor-pokupki-kvartiry-s-materinskim-kapitalom.doc" class="document-link" target="_blank">Договор покупки квартиры с материнским капиталом</a>
        </li>
        <li class="document-item">
            <a href="docs/dogovor-predoplaty.doc" class="document-link" target="_blank">Договор предоплаты</a>
        </li>
        <li class="document-item">
            <a href="docs/konsensualnyy-dogovor.doc" class="document-link" target="_blank">Консенсуальный договор</a>
        </li>
        <li class="document-item">
            <a href="docs/predvaritelnyy-dogovor.doc" class="document-link" target="_blank">Предварительный договор</a>
        </li>
        
        <!-- Добавьте другие документы по аналогии -->
    </ul>
    <li>
            <a href="rec.php" class="document-link">Рекомендации по выбору недвижимости</a>
        </li>
    
</body>
</html>
