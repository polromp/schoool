<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Панель управления базой учеников</title>
    <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}
h2 {
    color: #007bff;
}
form {
    margin-bottom: 20px;
}
label {
    font-weight: bold;
    margin-right: 10px;
}
select,
input[type="text"],
input[type="email"],
input[type="password"],
input[type="date"],
input[type="submit"] {
    padding: 8px;
    border-radius: 5px;
    margin-bottom: 10px;
}
table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
}
th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}
th {
    background-color: #f2f2f2;
}
.result {
    margin-top: 20px;
    padding: 10px;
    border-radius: 5px;
    background-color: #fff;
}
.success {
    color: green;
}
.error {
    color: red;
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
  <?php
  $mysqli = new mysqli('localhost', 'root', 'root', 'register-bd');
  if ($mysqli->connect_error) {
      die('Ошибка подключения (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
  }
//3123214
  $query = "SELECT DISTINCT class FROM students";
  $result = $mysqli->query($query);
  $classes = [];

  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $classes[] = $row['class'];
      }
  }

  echo "<h2>Выбор класса:</h2>";
  echo "<form method='post'>";
  echo "<label for='class'>Выберите класс:</label>";
  echo "<select name='class' id='class'>";
  echo "<option value=''>Все классы</option>";

  if (!empty($classes)) {
      foreach ($classes as $class) {
          echo "<option value='$class'>$class</option>";
      }
  }

  echo "</select>";
  echo "<input type='submit' name='submit' value='Показать учеников'>";
  echo "</form>";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $selected_class = $_POST['class'];
        $condition = "";
        if (!empty($selected_class)) {
            $condition = " WHERE class = '$selected_class'";
        }

        $query = "SELECT snils, surname, name, patronymic, email, password, date, class FROM students" . $condition;
        $result = $mysqli->query($query);

        if ($result) {
            if ($result->num_rows > 0) {
                echo "<h2>Ученики класса $selected_class:</h2>";
                echo "<table>";
                echo "<tr><th>СНИЛС</th><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Email</th><th>Пароль</th><th>Класс</th><th>Дата рождения</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['snils'] . "</td>";
                    echo "<td>" . $row['surname'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['patronymic'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['password'] . "</td>";
                    echo "<td>" . $row['class'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "</tr>";
                }
                //uytuyt
                // kjhkjh
                echo "</table>";
            } else {
                echo '<p style="color: red;">Ученики данного класса не найдены</p>';
            }
        } else {
            echo '<p style="color: red;">Ошибка запроса к базе данных</p>';
        }
    }

    echo "<h2>Добавить ученика:</h2>";
    echo "<form method='post'>";
    echo "<label for='snils'>СНИЛС:</label>";
    echo "<input type='text' name='snils'><br>";
    echo "<label for='surname'>Фамилия:</label>";
    echo "<input type='text' name='surname'><br>";
    echo "<label for='name'>Имя:</label>";
    echo "<input type='text' name='name'><br>";
    echo "<label for='patronymic'>Отчество:</label>";
    echo "<input type='text' name='patronymic'><br>";
    echo "<label for='email'>Email:</label>";
    echo "<input type='email' name='email'><br>";
    echo "<label for='password'>Пароль:</label>";
    echo "<input type='password' name='password'><br>";
    echo "<label for='class'>Класс:</label>";
    echo "<input type='text' name='class'><br>";
    echo "<label for='date'>Дата рождения:</label>";
    echo "<input type='date' name='date'><br>";
    echo "<input type='submit' name='add_student' value='Добавить'>";
    echo "</form>";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_student'])) {
        $snils = $_POST['snils'];
        $surname = $_POST['surname'];
        $name = $_POST['name'];
        $patronymic = $_POST['patronymic'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $class = $_POST['class'];
        $date = $_POST['date'];

        $query = "INSERT INTO students (snils, surname, name, patronymic, email, password, class, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ssssssss', $snils, $surname, $name, $patronymic, $email, $password, $class, $date);

        if ($stmt->execute()) {
            echo '<p style="color: green;">Ученик успешно добавлен!</p>';
        } else {
            echo '<p style="color: red;">Ошибка при добавлении ученика: ' . $stmt->error . '</p>';
        }

        $stmt->close();

        $class1 = intval(substr($class, 0, -1));

        if ($class1 >= 1 && $class1 <= 4) {
          $lvl = 14;
        } elseif ($class1 >= 5 && $class1 <= 9) {
          $lvl = 59;
        } else {
          $lvl = 1011;
        }

        // Добавление класса в таблицу `class`
        $queryAddClass = "INSERT INTO class (class, lvl) VALUES (?, ?)";
        $stmtAddClass = $mysqli->prepare($queryAddClass);
        $stmtAddClass->bind_param('si', $class, $lvl);

        if ($stmtAddClass->execute()) {
            echo '<p style="color: green;">Класс успешно добавлен!</p>';
        } else {
            echo '<p style="color: red;">Ошибка при добавлении класса: ' . $stmtAddClass->error . '</p>';
        }

        $stmtAddClass->close();
    }

    // Форма для удаления ученика и поиска по имени и фамилии
    echo "<h2>Удалить ученика / Поиск по имени и фамилии:</h2>";
    echo "<form method='post'>";
    echo "<label for='delete_snils'>Выберите СНИЛС ученика для удаления:</label>";
    echo "<select name='delete_snils' id='delete_snils'>";
    // Вывод списка учеников для выбора удаления
    $query = "SELECT snils, surname, name FROM students";
    $result = $mysqli->query($query);
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['snils'] . "'>" . $row['snils'] . " - " . $row['surname'] . " " . $row['name'] . "</option>";
            }
        }
    } else {
        echo '<option value="">Ошибка загрузки данных</option>';
    }
    echo "</select>";
    echo "<input type='submit' name='delete_student' value='Удалить'>";
    echo "<br><br>";
    echo "<label for='search_name'>Поиск по имени и фамилии:</label>";
    echo "<input type='text' name='search_name' id='search_name'>";
    echo "<input type='submit' name='search_student' value='Искать'>";
    echo "</form>";

    // Обработка формы удаления ученика
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_student'])) {
        $delete_snils = $_POST['delete_snils'];
        $delete_query = "DELETE FROM students WHERE snils = ?";
        $delete_stmt = $mysqli->prepare($delete_query);
        $delete_stmt->bind_param('s', $delete_snils);
        if ($delete_stmt->execute()) {
            echo '<p style="color: green;">Ученик успешно удален!</p>';
        } else {
            echo '<p style="color: red;">Ошибка при удалении ученика: ' . $delete_stmt->error . '</p>';
        }
        $delete_stmt->close();
    }

    // Обработка формы поиска по имени и фамилии
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_student'])) {
        $search_name = $_POST['search_name'];
        $search_query = "SELECT snils, surname, name, patronymic, email, password, date, class FROM students WHERE surname LIKE ? OR name LIKE ?";
        $search_stmt = $mysqli->prepare($search_query);
        $search_param = "%$search_name%";
        $search_stmt->bind_param('ss', $search_param, $search_param);
        $search_stmt->execute();
        $search_result = $search_stmt->get_result();
        if ($search_result->num_rows > 0) {
            echo "<h2>Результаты поиска:</h2>";
            echo "<table>";
            echo "<tr><th>СНИЛС</th><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Email</th><th>Пароль</th><th>Класс</th><th>Дата рождения</th></tr>";
            while ($row = $search_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['snils'] . "</td>";
                echo "<td>" . $row['surname'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['patronymic'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['password'] . "</td>";
                echo "<td>" . $row['class'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo '<p style="color: red;">Ничего не найдено</p>';
        }
        $search_stmt->close();
    }

    $mysqli->close();
    ?>
</body>
</html>
