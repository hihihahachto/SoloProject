<?php
session_start();

if ($_POST) {
    if ($_POST['password'] == '12345') {
        $_SESSION['admin'] = true;
        header('Location: admin_panel.php');
        exit;
    }
    $error = 'Неверный пароль';
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход для админа</title>
    <link rel="stylesheet" href="../css/main.css">
    <style>
        .login-box {
            max-width: 400px;
            margin: 100px auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #ccc;
        }
        button {
            background: #2e7d32;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body style="background: #f0f7f0;">

<div class="login-box">
    <h1 style="color: #1a5a1e;">Вход для админа</h1>
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="POST">
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
    <p style="margin-top: 20px;"><a href="../views/foundation.php" style="color: #666;">← На главную</a></p>
</div>

</body>
</html>