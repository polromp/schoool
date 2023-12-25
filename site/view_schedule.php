<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Просмотр расписания</title>
</head>
<body>
    <?php
        session_start();
        $targetFile = $_SESSION['var_namee'];
        $filePath = "$targetFile";
        echo "Путь к изображению: " . $filePath; // Добавлен этот код для вывода пути
    ?>
    <h2>Просмотр расписания</h2>
    <img src="female/<?php echo $filePath; ?>" alt="Расписание">
    <br>
    <a href="<?php echo $filePath; ?>" download>Скачать расписание</a>
</body>
</html>
