<?php
// Обработка сохранения новостей
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $newsText = $_POST['newsText'];

    if ($_FILES["imageFile"]["size"] > 0) {
        $targetDir = "novost/";
        $news_id = uniqid(); // Генерация уникаaльного идентификатора для новости
        $image_extension = pathinfo($_FILES["imageFile"]["name"], PATHINFO_EXTENSION);
        $image_file = "{$targetDir}{$news_id}.{$image_extension}";

        move_uploaded_file($_FILES["imageFile"]["tmp_name"], $image_file);
    }

    $text_file = "{$targetDir}{$news_id}.txt";
    file_put_contents($text_file, $newsText);

    header("Location: edit_news.php");
    exit;
}
?>
//sdasdsa
