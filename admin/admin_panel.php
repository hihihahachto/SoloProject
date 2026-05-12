<?php
require_once '../model/database.php';

// Получаем токен из адресной строки
$token = $_GET['token'] ?? '';

// Проверяем, есть ли такой токен в БД
$sql = "SELECT * FROM admins WHERE token = :token";
$stmt = $pdo->prepare($sql);
$stmt->execute([':token' => $token]);
$admin = $stmt->fetch();

// Если токен неверный — выкидываем
if (!$admin) {
    die('Доступ запрещён. Неверный токен.');
}

// Если всё ок — показываем админ-панель
$unreadCount = getUnreadCount($pdo);
$notifications = getUnreadNotifications($pdo);
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ панель</title>
    <link rel="stylesheet" href="../css/main.css">
    <style>
        .admin-menu { max-width: 600px; margin: 50px auto; text-align: center; }
        .admin-menu a { display: block; background: white; margin: 20px; padding: 20px; border-radius: 20px; text-decoration: none; color: #1a5a1e; font-size: 18px; transition: 0.3s; }
        .admin-menu a:hover { background: #e8f5e9; transform: translateY(-3px); }
        .notifications-box { background: white; border-radius: 20px; padding: 20px; margin-bottom: 30px; text-align: left; }
        .badge { background: #ea2929; color: white; border-radius: 50%; padding: 2px 8px; font-size: 12px; margin-left: 10px; }
        .token-info { background: #fff3cd; padding: 10px; border-radius: 10px; margin-bottom: 20px; font-size: 12px; word-break: break-all; }
    </style>
</head>
<body style="background: #f0f7f0;">

<div class="admin-menu">
    <h1 style="color: #1a5a1e;">Админ панель</h1>

    <div class="token-info">
        ⚠️ Ваш токен: <code><?= htmlspecialchars($token) ?></code><br>
        Сохраните ссылку: <code>admin_panel.php?token=<?= htmlspecialchars($token) ?></code>
    </div>

    <div class="notifications-box">
        <h3>🔔 Уведомления <span class="badge"><?= $unreadCount ?></span></h3>
        <?php foreach ($notifications as $notif): ?>
            <div style="padding: 8px; border-bottom: 1px solid #eee;"><?= htmlspecialchars($notif['message']) ?> (<?= $notif['created_at'] ?>)</div>
        <?php endforeach; ?>
        <?php if (empty($notifications)) echo "<div>Нет новых уведомлений</div>"; ?>
    </div>

    <a href="animals_edit.php?token=<?= urlencode($token) ?>">🐾 Редактировать животных</a>
    <a href="volunteers_edit.php?token=<?= urlencode($token) ?>">🙋 Редактировать волонтёров</a>
    <a href="admin_login.php">🚪 Выйти</a>
    <a href="../views/foundation.php">← На сайт</a>
</div>

</body>
</html>