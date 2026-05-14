<?php
require_once 'database.php';

$token = $_GET['token'] ?? '';

$sql = "SELECT * FROM admins WHERE token = :token";
$stmt = $pdo->prepare($sql);
$stmt->execute([':token' => $token]);
$admin = $stmt->fetch();

if (!$admin) {
    die('Доступ запрещён. Неверный токен.');
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ панель</title>
    <link rel="stylesheet" href="../../front/css/main.css">
    <style>
        .admin-menu { max-width: 600px; margin: 50px auto; text-align: center; }
        .admin-menu a { display: block; background: white; margin: 20px; padding: 20px; border-radius: 20px; text-decoration: none; color: #1a5a1e; font-size: 18px; transition: 0.3s; }
        .admin-menu a:hover { background: #e8f5e9; transform: translateY(-3px); }
    </style>
</head>
<body style="background: #f0f7f0;">

<div class="admin-menu">
    <h1 style="color: #1a5a1e;">Админ панель</h1>

    <a href="animals_edit.php?token=<?= urlencode($token) ?>">Редактировать животных</a>
    <a href="volunteers_edit.php?token=<?= urlencode($token) ?>">Редактировать волонтёров</a>
    <a href="admin_login.php">Выйти</a>
    <a href="foundation.php">
</div>

</body>
</html>