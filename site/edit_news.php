<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Редактирование новостей</title>
</head>
<body>
    <h1>Редактирование новостей</h1>

    <form action="save_news.php" method="post" enctype="multipart/form-data">
        <label for="newsText">Текст новости:</label>
        <textarea id="newsText" name="newsText" rows="4" cols="50"></textarea>
        <br>
        <label for="newsImage">Изображение:</label>
        <input type="file" name="imageFile" id="newsImage"> <!-- Указано name="imageFile" -->
        <br>
        <input type="submit" value="Сохранить" name="submit"> <!-- Указано name="submit" -->
        // fgfgfg
    </form>
</body>
</html>
