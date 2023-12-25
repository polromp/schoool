<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация ученика</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 320px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
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
    <div class="container">
        <h1>Авторизация ученика</h1>
        <form action="auth.php" method="post">
            <div class="form-group">
                <label for="snils">Введите СНИЛС:</label>
                <input type="text" id="snils" name="snils" required>
            </div>
            <div class="form-group">
                <label for="password">Введите пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Войти</button>
            // вава
        </form>
    </div>
</body>
</html>
