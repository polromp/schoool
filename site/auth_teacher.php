<?php
session_start();

$login = filter_var(trim($_POST['snils']), FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);

$mysql = new mysqli('localhost', 'root', 'root', 'register-bd');

if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}

$result = $mysql->query("SELECT * FROM teacher WHERE snils = '$login' AND password = '$pass'");

$user = $result->fetch_assoc();

if ($user) {
    $_SESSION['user'] = $user;
    $mysql->close();
    header('Location: cabinet_uchitela.php?var_name='. urlencode($login));
    exit();
}
//dhsjakfg
//eqeqw
$result = $mysql->query("SELECT * FROM director WHERE snils = '$login' AND password = '$pass'");
$user = $result->fetch_assoc();

if ($user) {
    $_SESSION['user'] = $user;
    $mysql->close();
    header('Location: cabinet_directora.php');
    exit();
}

$mysql->close();
echo "Такой пользователь не найден";
?>
//312312
