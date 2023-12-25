<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Панель управления базой учителей</title>
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

        .container_img{
          height: 100vh;
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
    ?>

    <!-- Вывод баaзы данных всех учителей -->
    <h2>База учителей:</h2>
    <table>
        <tr>
            <th>СНИЛС</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Email</th>
            <th>Пароль</th>
            <th>Класс</th>
            <th>Дата рождения</th>
        </tr>
        <?php
        $query = "SELECT snils, surname, name, patronymic, email, password, class, date FROM teacher";
        $result = $mysqli->query($query);

        if ($result->num_rows > 0) {
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
        } else {
            echo '<tr><td colspan="8" style="color: red;">Нет данных об учителях</td></tr>';
            //89768768
        }
        //32132131
        ?>
        
    </table>

    <!-- Форма для удаления учителя -->
    <h2>Удалить учителя:</h2>
    <form method="post">
        <label for="delete_snils">Выберите СНИЛС учителя:</label>
        <select name="delete_snils" id="delete_snils">
            <?php
            $query = "SELECT snils, surname, name FROM teacher";
            $result = $mysqli->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['snils'] . "'>" . $row['snils'] . " - " . $row['surname'] . " " . $row['name'] . "</option>";
                }
            }
            ?>
        </select>
        <input type="submit" name="delete_teacher" value="Удалить">
    </form>

    <!-- Форма для добавления учителя -->
    <h2>Добавить учителя:</h2>
    <form method='post'>
        <label for='snils'>СНИЛС:</label>
        <input type='text' name='snils'><br>
        <label for='surname'>Фамилия:</label>
        <input type='text' name='surname'><br>
        <label for='name'>Имя:</label>
        <input type='text' name='name'><br>
        <label for='patronymic'>Отчество:</label>
        <input type='text' name='patronymic'><br>
        <label for='email'>Email:</label>
        <input type='email' name='email'><br>
        <label for='password'>Пароль:</label>
        <input type='password' name='password'><br>
        <label for='class'>Класс:</label>
        <select name='class' id='class'>
            <option value='4Г'>4Г</option>
            <option value='11Б'>11Б</option>
            <!-- Добавьте остальные варианты классов -->
        </select><br>
        <label for='date'>Дата рождения:</label>
        <input type='date' name='date'><br>
        <input type='submit' name='add_teacher' value='Добавить'>
    </form>

    <?php
    if (isset($_POST['delete_teacher'])) {
        $delete_snils = $_POST['delete_snils'];
        $delete_query = "DELETE FROM teacher WHERE snils = '$delete_snils'";
        if ($mysqli->query($delete_query) === TRUE) {
            echo "<p style='color: green;'>Учитель успешно удален</p>";
        } else {
            echo "<p style='color: red;'>Ошибка при удалении: " . $mysqli->error . "</p>";
        }
        //fgfgfg
    }

    if (isset($_POST['add_teacher'])) {
        $snils = $_POST['snils'];
        $surname = $_POST['surname'];
        $name = $_POST['name'];
        $patronymic = $_POST['patronymic'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $class = $_POST['class'];
        $date = $_POST['date'];

        $insert_query = "INSERT INTO teacher (snils, surname, name, patronymic, email, password, class, date) VALUES ('$snils', '$surname', '$name', '$patronymic', '$email', '$password', '$class', '$date')";
        if ($mysqli->query($insert_query) === TRUE) {
            echo "<p style='color: green;'>Учитель успешно добавлен</p>";
        } else {
            echo "<p style='color: red;'>Ошибка при добавлении: " . $mysqli->error . "</p>";
        }
    }

    $mysqli->close();
    ?>
</body>
</html>
