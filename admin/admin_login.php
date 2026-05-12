<?php
require_once '../model/database.php';

$error = '';

if ($_POST) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Ищем админа по логину
    $sql = "SELECT * FROM admins WHERE login = :login";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':login' => $login]);
    $admin = $stmt->fetch();

    // Проверяем пароль как обычный текст (без хеша)
    if ($admin && $password == $admin['password']) {
        // Берём токен из БД и передаём его в GET
        $token = $admin['token'];
        header("Location: admin_panel.php?token=" . urlencode($token));
        exit;
    } else {
        $error = 'Неверный логин или пароль';
    }
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
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
    <p style="margin-top: 20px;"><a href="../views/foundation.php" style="color: #666;">← На главную</a></p>
</div>

</body>
</html>