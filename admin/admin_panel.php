<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}

require_once '../model/Database.php';

if (isset($_GET['read'])) {
    $sql = "UPDATE notifications SET is_read = 1 WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_GET['read']]);
    header('Location: admin_panel.php');
    exit;
}

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
        .notifications-box h3 { margin-bottom: 15px; }
        .notification { padding: 10px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
        .notification:last-child { border-bottom: none; }
        .notification-date { color: #999; font-size: 12px; }
        .read-link { color: #2e7d32; text-decoration: none; font-size: 12px; }
        .no-notifications { color: #999; text-align: center; padding: 20px; }
        .badge { background: #ea2929; color: white; border-radius: 50%; padding: 2px 8px; font-size: 12px; margin-left: 10px; }
    </style>
</head>
<body style="background: #f0f7f0;">

<div class="admin-menu">
    <h1 style="color: #1a5a1e;">Админ панель</h1>

    <div class="notifications-box">
        <h3>🔔 Уведомления <span class="badge"><?= $unreadCount ?></span></h3>
        <?php if (empty($notifications)): ?>
            <div class="no-notifications">Нет новых уведомлений</div>
        <?php else: ?>
            <?php foreach ($notifications as $notif): ?>
                <div class="notification">
                    <div>
                        <span><?= htmlspecialchars($notif['message']) ?></span>
                        <div class="notification-date"><?= $notif['created_at'] ?></div>
                    </div>
                    <a href="admin_panel.php?read=<?= $notif['id'] ?>" class="read-link">Прочитано</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <a href="animals_edit.php">Редактировать животных</a>
    <a href="volunteers_edit.php">Редактировать волонтёров</a>
    <a href="logout.php">Выйти</a>
    <a href="../views/foundation.php">← На сайт</a>
</div>

</body>
</html>