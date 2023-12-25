<?php
        $login = filter_var(trim($_POST['snils']), FILTER_SANITIZE_STRING);
        $pass = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);

        $mysql = new mysqli('localhost', 'root', 'root', 'register-bd');

        if ($mysql->connect_error) {
            die("Ошибка подключения: " . $mysql->connect_error);
        }

        $result = $mysql->query("SELECT * FROM students WHERE snils = '$login' AND password = '$pass'");

        $user = $result->fetch_assoc();
        if (!$user) {
            echo "Такой пользователь не найден";
            exit();
        }

        header('Location: cabinet_uchenika.php?var_name='. urlencode($login));
        $mysql->close();
        exit();
?>
//treewq
