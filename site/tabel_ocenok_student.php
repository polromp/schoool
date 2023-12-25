<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Табель оценок</title>
    <style>
    body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 20px;
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
    <h1>Табель оценок</h1>
    <?php
    $mysqli = new mysqli('localhost', 'root', 'root', 'register-bd');
    if ($mysqli->connect_error) {
        die('Ошибка подключения (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    //$login = $_GET['vaaar_name'];
    session_start();
    $login = $_SESSION['var_name']; 

    $queryClass = "SELECT class FROM students WHERE snils = '$login'";
    $resultClass = $mysqli->query($queryClass);

    if ($resultClass->num_rows > 0) {
        $rowClass = $resultClass->fetch_assoc();
        $studentClass = intval(substr($rowClass['class'], 0, -1));

        $subjectsDB = '';
        if ($studentClass >= 1 && $studentClass <= 4) {
            $subjectsDB = 'predmet14';
        } elseif ($studentClass >= 5 && $studentClass <= 9) {
            $subjectsDB = 'predmet59';
        } elseif ($studentClass >= 10 && $studentClass <= 11) {
            $subjectsDB = 'predmet1011';
        }

        $querySubjects = "SELECT id, predmet FROM $subjectsDB";
        $resultSubjects = $mysqli->query($querySubjects);

        if ($resultSubjects->num_rows > 0) {
            $subjects = array();
            while ($rowSubject = $resultSubjects->fetch_assoc()) {
                $subjects[$rowSubject['id']] = $rowSubject['predmet'];
            }

            // Вывод таблицы оценок
            $queryGrades = "SELECT data, id_predmeta, ocenka FROM grade WHERE snils_studenta = '$login'";
            $resultGrades = $mysqli->query($queryGrades);

            if ($resultGrades->num_rows > 0) {
                $grades = array();
                $dates = array();
                $subjectsGrades = array();

                while ($rowGrade = $resultGrades->fetch_assoc()) {
                    $data = $rowGrade['data'];
                    $id_predmeta = $rowGrade['id_predmeta'];
                    $ocenka = $rowGrade['ocenka'];

                    if (!in_array($data, $dates)) {
                        $dates[] = $data;
                    }

                    if (!in_array($id_predmeta, $subjectsGrades)) {
                        $subjectsGrades[] = $id_predmeta;
                    }

                    $grades[$data][$id_predmeta] = $ocenka;
                }

                echo '<table border="1">';
                echo '<tr><th>Предметы / Даты</th>';

                foreach ($dates as $data) {
                    echo '<th>' . $data . '</th>';
                }
                echo '</tr>';

                foreach ($subjects as $subjectId => $subjectName) {
                    echo '<tr><td>' . $subjectName . '</td>';
                    foreach ($dates as $data) {
                        echo '<td>';
                        echo isset($grades[$data][$subjectId]) ? $grades[$data][$subjectId] : '';
                        echo '</td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo 'Нет данных об оценках для этого студента';
            }
        } else {
            echo 'Нет данных о предметах для этого класса';
        }
    } else {
        echo 'Класс ученика не определен';
    }

    $mysqli->close();
    ?>
</body>
</html>
