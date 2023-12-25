<?php
// Подключение к базе данных (используя PDO)

$host = 'localhost'; // Замените на ваш хост, если это не localhost
$db_name = 'имя_вашей_базы_данных'; // Замените на имя вашей базы данных
$username = 'ваше_имя_пользователя'; // Замените на имя пользователя базы данных
$password = 'ваш_пароль'; // Замените на пароль для подключения к базе данных

try {
  $mysqli = new mysqli('localhost', 'root', 'root', 'register-bd');
  if ($mysqli->connect_error) {
      die('Ошибка подключения (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
  }
    // Запрос к базе данных для выбора преподавателей и их предметов обучения
    $query = "SELECT name, surname, patronymic, post, id_predmeta FROM teacher";

    $stmt = $pdo->query($query);
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>
//dsada
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Преподаватели</title>
    <!-- Дополнительные теги стилей или скрипты, если необходимо -->
</head>
<body>
    <h1>Преподаватели и их предметы обучения</h1>
    <ul>
        <?php foreach ($teachers as $teacher): ?>
            <li>
                <strong><?= $teacher['teacher_name'] ?>:</strong>
                <?= $teacher['subject_name'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
