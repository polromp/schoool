<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Загрузить расписание</title>
</head>
<body>
    <h2>Загрузить расписание</h2>
    <form action="upload_process.php" method="post" enctype="multipart/form-data">
        <input type="file" name="scheduleFile" id="scheduleFile">
        <input type="submit" value="Загрузить" name="submit">
    </form>
</body>
</html>
