<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Страница с оценками</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select,
        input[type="submit"] {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        th,
        td {
            border: 1px solid #ddd;
        }

        .red-text {
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
    <div class="container">
<?
$mysqli = new mysqli('localhost', 'root', 'root', 'register-bd');

if ($mysqli->connect_error) {
    die('Ошибка подключения (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

//$login = $_GET['vaar_name'] ?? '';

session_start();
$login = $_SESSION['var_name'];

$querySubject = "SELECT id_predmeta FROM teacher WHERE snils = '$login'";
$resultSubject = $mysqli->query($querySubject);

if ($resultSubject) {
    if ($resultSubject->num_rows > 0) {
        $rowSubject = $resultSubject->fetch_assoc();
        $subjectId = $rowSubject['id_predmeta'];

        $querySubjectName = "SELECT predmet FROM predmet WHERE id = '$subjectId'";
        $resultSubjectName = $mysqli->query($querySubjectName);

        if ($resultSubjectName) {
            if ($resultSubjectName->num_rows > 0) {
                $rowSubjectName = $resultSubjectName->fetch_assoc();
                $subjectName = $rowSubjectName['predmet'];

                $subjectsDBs = ['predmet14', 'predmet59', 'predmet1011'];
                $classes = [];

                foreach ($subjectsDBs as $subjectDB) {
                    $queryCheckSubject = "SELECT predmet FROM $subjectDB WHERE predmet = '$subjectName'";
                    $resultCheckSubject = $mysqli->query($queryCheckSubject);

                    if ($resultCheckSubject->num_rows > 0) {
                        $lvl = '';
                        if ($subjectDB === "predmet14") {
                            $lvl = 14;
                        } elseif ($subjectDB === "predmet59") {
                            $lvl = 59;
                        } elseif ($subjectDB === "predmet1011") {
                            $lvl = 1011;
                        }

                        $query = "SELECT DISTINCT class FROM class WHERE lvl = '$lvl'";
                        $result = $mysqli->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $classes[] = $row['class'];
                            }
                        }
                    }
                }

                if (!empty($classes)) {
                    echo '<style> /* ваш стиль */ </style>';

                    echo '<form method="post">';
                    echo '<label for="month">Выберите месяц:</label>';
                    echo '<select id="month" name="selected_month">';
                    for ($month = 1; $month <= 12; $month++) {
                        echo "<option value='$month'>" . date('F', mktime(0, 0, 0, $month, 1)) . "</option>";
                    }
                    echo '</select>';

                    echo '<label for="classes">Выберите класс:</label>';
                    echo '<select id="classes" name="selected_class">';
                    foreach ($classes as $class) {
                        echo "<option value='$class'>$class</option>";
                    }
                    echo '</select>';
                    echo '<input type="submit" name="submit" value="Показать оценки">';
                    echo '</form>';

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                        $selectedClass = $_POST['selected_class'] ?? '';
                        $selectedMonth = $_POST['selected_month'] ?? '';
                        $condition = !empty($selectedClass) ? " WHERE class = '$selectedClass'" : '';

                        $queryStudents = "SELECT * FROM students" . $condition;
                        $resultStudents = $mysqli->query($queryStudents);

                        if ($resultStudents) {
                            if ($resultStudents->num_rows > 0) {
                                echo "<h2>Оценки для $selectedClass класса в " . date('F', mktime(0, 0, 0, $selectedMonth, 1)) . ":</h2>";
                                echo "<form method='post'>";
                                echo "<table>";
                                echo "<tr><th>Ученик</th>";
                                for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $selectedMonth, date('Y')); $day++) {
                                    $timestamp = mktime(0, 0, 0, $selectedMonth, $day);
                                    $dayOfWeek = date('D', $timestamp);
                                    $date = date('Y-m-d', $timestamp);
                                    if ($dayOfWeek === 'Sat' || $dayOfWeek === 'Sun') {
                                        echo "<th style='background-color: #f9a5a5;'>$day<br>$dayOfWeek</th>";
                                    } else {
                                        echo "<th>$day<br>$dayOfWeek</th>";
                                    }
                                }
                                echo "</tr>";
                                while ($row = $resultStudents->fetch_assoc()) {
    echo "<tr>";
    echo "<td class='fio-column'>" . $row['surname'] . ' ' . $row['name'] . ' ' . $row['patronymic'] . "</td>";

    for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $selectedMonth, date('Y')); $day++) {
        $timestamp = mktime(0, 0, 0, $selectedMonth, $day);
        $date = date('Y-m-d', $timestamp);
        $inputName = "grades[{$row['snils']}][$date]";

        // Новый код для получения существующих оценок
        $studentId = $row['snils'];
        $queryExistingGrades = "SELECT ocenka FROM grade WHERE snils_studenta = '$studentId' AND data = '$date' AND id_predmeta = '$subjectId'";
        $resultExistingGrades = $mysqli->query($queryExistingGrades);

        if ($resultExistingGrades && $resultExistingGrades->num_rows > 0) {
            $existingGrade = $resultExistingGrades->fetch_assoc();
            $gradeValue = $existingGrade['ocenka'];
            echo "<td><input type='number' name='$inputName' min='1' max='5' value='$gradeValue'></td>";
        } else {
            echo "<td><input type='number' name='$inputName' min='1' max='5'></td>";
        }
    }

    echo "</tr>";
}
                                echo "</table>";
                                echo "<input type='hidden' name='selected_month' value='$selectedMonth'>";
                                echo "<input type='hidden' name='selected_class' value='$selectedClass'>";
                                echo "<input type='submit' name='save' value='Сохранить оценки'>";
                                echo "</form>";
                            } else {
                                echo '<p style="color: red;">Ученики данного класса не найдены</p>';
                            }
                        } else {
                            echo '<p style="color: red;">Ошибка запроса к базе данных</p>';
                        }
                    }
                } else {
                    echo 'Подходящих классов не найдено';
                }
            } else {
                echo 'Название предмета не найдено';
            }
        } else {
            echo 'Ошибка запроса на получение названия предмета: ' . $mysqli->error;
        }
    } else {
        echo 'Предмет учителя не найден';
    }
} else {
    echo 'Ошибка запроса на получение предмета учителя: ' . $mysqli->error;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $selectedMonth = $_POST['selected_month'];
    $selectedClass = $_POST['selected_class'];
    $grades = $_POST['grades'];

    $query = "INSERT INTO grade (id_predmeta, snils_studenta, ocenka, data) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE ocenka = VALUES(ocenka)";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        die('Ошибка подготовки запроса (' . $mysqli->errno . ') ' . $mysqli->error);
    }

    foreach ($grades as $studentId => $studentGrades) {
        foreach ($studentGrades as $date => $grade) {
            if ($grade){
                // Проверка наличия записи перед вставкой или обновлением
                $checkQuery = "SELECT COUNT(*) AS count FROM grade WHERE id_predmeta = ? AND snils_studenta = ? AND data = ?";
                $checkStmt = $mysqli->prepare($checkQuery);

                if (!$checkStmt) {
                    die('Ошибка подготовки запроса (' . $mysqli->errno . ') ' . $mysqli->error);
                }

                $checkStmt->bind_param('iis', $subjectId, $studentId, $date);
                $checkStmt->execute();
                $checkResult = $checkStmt->get_result();
                $row = $checkResult->fetch_assoc();

                // Если запись существует, обновляем оценку
                if ($row['count'] > 0) {
                    $updateQuery = "UPDATE grade SET ocenka = ? WHERE id_predmeta = ? AND snils_studenta = ? AND data = ?";
                    $updateStmt = $mysqli->prepare($updateQuery);

                    if (!$updateStmt) {
                        die('Ошибка подготовки запроса (' . $mysqli->errno . ') ' . $mysqli->error);
                    }

                    $updateStmt->bind_param('iiis', $grade, $subjectId, $studentId, $date);
                    $updateStmt->execute();
                    $updateStmt->close();
                } else {
                    // Иначе, вставляем новую оценку
                    $stmt->bind_param('iiis', $subjectId, $studentId, $grade, $date);
                    $stmt->execute();
                }

                $checkStmt->close();
            }
        }
    }

    $stmt->close();

    echo 'Оценки успешно сохранены в базе данных!';
}

$mysqli->close();

?>
</div>
</body>
</html>
