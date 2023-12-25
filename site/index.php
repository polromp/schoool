<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Главная страница школы</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Стили для сайдбара */
        .sidebar {
            width: 200px;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 8px 0 0 8px;
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
            color: #333;
            text-decoration: none;
            transition: color 0.3s;
        }

        .sidebar ul li a:hover {
            color: #007bff;
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

        .user-type {
            display: flex;
            justify-content: space-between;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
            background-color: #007bff;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }
        .img {
          height: 70px;
          width: 70px;
        }

        .container_img{
          height: 100vh;
        }
        .news-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .news-item {
            flex-basis: calc(33.333% - 20px); /* Пример ширины для 3 столбцов с отступами */
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            box-sizing: border-box;
        }

        .news-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .news-text {
            font-size: 14px;
        }
        h1 {
            margin-bottom: 20px;
        }

        .user-type form {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .user-type form button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
            background-color: #007bff;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .user-type form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
  <div class="container_img">
  <a href="index.php">
      <img src="http://pic.rutubelist.ru/user/92/fd/92fd00fcf41df522196e767a7bae7bb5.jpg" alt="Логотип сайта" class = "img">
  </a>
</div>
  <div class="container">
      <div class="sidebar">
          <h2>Меню</h2>
          <ul>
              <li><a href="eda_v_shkole.php">Еда в школе</a></li>
              <li><a href="teachers.php">Преподаватели</a></li>
              <li><a href="dostizheniya.php">Достижения</a></li>
              <li><a href="dostizheniya.php">Образовательные программы</a></li>
              <li><a href="dostizheniya.php">Сведения об образовательной организации</a></li>
              <li><a href="dostizheniya.php">Одарённые дети</a></li>
              <!-- Добавьте другие пункты меню -->
          </ul>
      </div>
//321
    <div class="content">
      <div class="content">
          <header>
              <h1>Главная страница школы</h1>
              <div class="user-type">
                  <form action="login_teacher_and_director.php" method="post">
                      <button type="submit" class="btn" name="teacher-login">Учителю</button>
                  </form>
                  <form action="login_student.php" method="post">
                      <button type="submit" class="btn" name="student-login">Ученику</button>
                  </form>
              </div>
          </header>
          <header><h2>Новости школы</h2></header>
        <div id="newsFeed" class="news-container">


            <?php
            $newsDirectory = 'novost/';
            $newsFiles = glob($newsDirectory . '*.txt');

            foreach ($newsFiles as $textFile) {
                $imageFile = str_replace('.txt', '.jpg', $textFile);

                if (file_exists($textFile) && file_exists($imageFile)) {
                    $newsText = file_get_contents($textFile);
                    echo '<div class="news-item">';
                    echo '<img src="' . $imageFile . '" class="news-image">';
                    echo '<div class="news-text">' . nl2br($newsText) . '</div>';
                    echo '</div>';
                    // fgfgfg
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
