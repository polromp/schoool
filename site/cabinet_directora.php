<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Страница директора</title>
    <style>
        /* Общие стилиi */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            display: flex;
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Стили для сайдбара */
        .sidebar {
            width: 200px;
            padding: 20px;
            background-color: #007bff;
            border-radius: 8px 0 0 8px;
            color: #fff;
        }

        .sidebar h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li a {
            display: block;
            padding: 8px 0;
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .sidebar ul li a:hover {
            color: #f0f0f0;
        }

        /* Стили для контента */
        .content {
            flex: 1;
            padding: 20px;
        }

        header {
            padding-bottom: 20px;
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        section {
            margin-bottom: 20px;
        }

        section h2 {
            color: #007bff;
        }

        section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        section ul li a {
            display: block;
            padding: 6px 0;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        section ul li a:hover {
            color: #0056b3;
        }

        /* Дополнительные стили для информации о человеке */
        .info-container {
            text-align: center;
            width: 400px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .info-container h1 {
            margin-bottom: 20px;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #ccc;
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info label {
            display: inline-block;
            width: 100px;
            font-weight: bold;
        }
        .img {
          height: 70px;
          width: 70px;
        }
    </style>
</head>
<body>
  <div class="container_img">
    <a href="index.html">
        <img src="https://abali.ru/wp-content/uploads/2018/09/ofitsialnyj-portret-putina.jpg" alt="Логотип сайта" class = "img">
    </a>
  </div>
    <div class="container">
        <div class="sidebar">
            <h2>Меню</h2>
            <ul>
                <li><a href="#">Профиль</a></li>
                <li><a href="#">Главное</a></li>
                <li>
                    <a href="#">Поддержка</a>
                    <ul>
                        <li><a href="baza_uchenikov.php">База данных учеников</a></li>
                        <li><a href="baza_uchiteley.php">База данных учителей</a></li>
                        <li><a href="edit_news.php">Редактировать ленту новостей</a></li>
                        <li><a href="raspisani.php">Редактировать расписание</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="content">
            <header>
                <h1>Информация о директоре</h1>
            </header>
            <main>
                <div class="info-container">
                    <?php
                        // Подключение к базе данных
                        $mysqli = new mysqli('localhost', 'root', 'root', 'register-bd');

                        // Проверка соединения
                        if ($mysqli->connect_error) {
                            die('Ошибка подключения (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
                        }

                        $query = "SELECT name, surname, patronymic, date, post, email FROM director WHERE id = 1";
                        $result = $mysqli->query($query);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo '<h1>' . $row['name'] . '</h1>';
                            echo '<div class="info"><label for="name">Имя:</label><span>' . $row['name'] . '</span></div>';
                            echo '<div class="info"><label for="surname">Фамилия:</label><span>' . $row['surname'] . '</span></div>';
                            echo '<div class="info"><label for="patronymic">Отчество:</label><span>' . $row['patronymic'] . '</span></div>';
                            echo '<div class="info"><label for="date">Дата:</label><span>' . $row['date'] . '</span></div>';
                            echo '<div class="info"><label for="class">Должность:</label><span>' . $row['post'] . '</span></div>';
                            echo '<div class="info"><label for="class">Электронная почта:</label><span>' . $row['email'] . '</span></div>';

                        } else {
                            echo 'Информация о директоре не найдена';
                            // iuyiuyiu
                            // 5746758
                        }

                        $mysqli->close();
                        //312312412
                    ?>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
