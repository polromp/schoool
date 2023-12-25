<?php
$targetDir = "C:/MAMP/htdocs/site/female/"; // Папка для хранения расписаний

// Проверка существования папки
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$targetFile = $targetDir . basename($_FILES["scheduleFile"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Проверка наличия файла
if ($_FILES["scheduleFile"]["size"] == 0) {
    echo "Файл не выбран.";
    $uploadOk = 0;
}

// Проверка формата файла (можно расширить для поддержки разных типов файлов)
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "Поддерживаются только JPG, JPEG, PNG файлы.";
    $uploadOk = 0;
}

// Проверка наличия файла с таким именем
if (file_exists($targetFile)) {
    echo "Файл с таким именем уже существует.";
    $uploadOk = 0;
}

// Если все проверки прошли успешно, загружаем файл
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["scheduleFile"]["tmp_name"], $targetFile)) {
        session_start();
        $_SESSION['var_namee'] = basename($_FILES["scheduleFile"]["name"]); // Здесь передается только название файла
        echo "Файл успешно загружен: " . basename($_FILES["scheduleFile"]["name"]);
    } else {
        echo "Произошла ошибка при загрузке файла.";
    }
}
?>
