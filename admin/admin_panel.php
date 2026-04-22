<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ панель</title>
    <link rel="stylesheet" href="../css/main.css">
    <style>
        .admin-menu {
            max-width: 600px;
            margin: 100px auto;
            text-align: center;
        }
        .admin-menu a {
            display: block;
            background: white;
            margin: 20px;
            padding: 20px;
            border-radius: 20px;
            text-decoration: none;
            color: #1a5a1e;
            font-size: 18px;
            transition: 0.3s;
        }
        .admin-menu a:hover {
            background: #e8f5e9;
            transform: translateY(-3px);
        }
    </style>
</head>
<body style="background: #f0f7f0;">

<div class="admin-menu">
    <h1 style="color: #1a5a1e;">Админ панель</h1>
    <a href="animals_edit.php">Редактировать животных</a>
    <a href="volunteers_edit.php">Редактировать волонтёров</a>
    <a href="logout.php">Выйти</a>
    <a href="../views/foundation.php">← На сайт</a>
</div>

</body>
</html>