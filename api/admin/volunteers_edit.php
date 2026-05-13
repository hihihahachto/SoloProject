<?php

require_once 'database.php';


$token = $_GET['token'] ?? '';
$sql = "SELECT * FROM admins WHERE token = :token";
$stmt = $pdo->prepare($sql);
$stmt->execute([':token' => $token]);
$admin = $stmt->fetch();
if (!$admin) {
    die('Доступ запрещён. Авторизуйтесь заново.');
}

require_once '../SoloProject/api/controller/VolunteerController.php';

if (isset($_GET['delete'])) {
    deleteVolunteer($pdo, $_GET['delete']);
    header('Location: volunteers_edit.php?token=' . urlencode($token));
    exit;
}

if (isset($_POST['edit'])) {
    updateVolunteer($pdo, $_POST['id'], $_POST['full_name'], $_POST['phone'], $_POST['skill'], $_POST['photo_url']);
    header('Location: volunteers_edit.php?token=' . urlencode($token));
    exit;
}

if (isset($_POST['add'])) {
    addVolunteer($pdo, $_POST['full_name'], $_POST['phone'], $_POST['skill'], $_POST['photo_url']);
    header('Location: volunteers_edit.php?token=' . urlencode($token));
    exit;
}

$volunteers = getAllVolunteers($pdo);

$edit = null;
if (isset($_GET['edit'])) {
    $edit = getVolunteerById($pdo, $_GET['edit']);
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Волонтёры</title>
    <link rel="stylesheet" href="../../front/css/main.css">
    <style>
        .container { max-width: 1200px; margin: 40px auto; background: white; padding: 30px; border-radius: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #1a5a1e; color: white; }
        tr:hover { background: #f5f5f5; }
        input, select { padding: 8px 12px; border-radius: 8px; border: 1px solid #ccc; width: 100%; }
        .btn { background: #2e7d32; color: white; padding: 5px 12px; border-radius: 20px; text-decoration: none; display: inline-block; margin: 2px; border: none; cursor: pointer; }
        .btn-gray { background: #6c757d; }
        .form-group { margin-bottom: 15px; }
        .form-section { background: #f9fbf7; padding: 20px; border-radius: 15px; margin-bottom: 30px; }
    </style>
</head>
<body style="background: #f0f7f0;">

<div class="container">
    <h1 style="color: #1a5a1e;">🙋 Волонтёры</h1>
    <a href="admin_panel.php?token=<?= urlencode($token) ?>">← Назад в панель</a>

    <?php if (!$edit): ?>
        <div class="form-section">
            <h3>➕ Добавить волонтёра</h3>
            <form method="POST">
                <div class="form-group"><label>ФИО:</label><br><input type="text" name="full_name" required></div>
                <div class="form-group"><label>Телефон:</label><br><input type="text" name="phone" required></div>
                <div class="form-group">
                    <label>Навык:</label><br>
                    <select name="skill">
                        <option value="feeding">Кормление</option>
                        <option value="walking">Выгул</option>
                        <option value="medical">Медицина</option>
                        <option value="cleaning">Уборка</option>
                    </select>
                </div>
                <div class="form-group"><label>Фото (ссылка):</label><br><input type="text" name="photo_url"></div>
                <button type="submit" name="add" class="btn">➕ Добавить</button>
            </form>
        </div>
    <?php endif; ?>

    <?php if ($edit): ?>
        <div class="form-section">
            <h3>✏️ Редактировать волонтёра</h3>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $edit['id'] ?>">
                <div class="form-group"><label>ФИО:</label><br><input type="text" name="full_name" value="<?= htmlspecialchars($edit['full_name']) ?>" required></div>
                <div class="form-group"><label>Телефон:</label><br><input type="text" name="phone" value="<?= htmlspecialchars($edit['phone']) ?>" required></div>
                <div class="form-group">
                    <label>Навык:</label><br>
                    <select name="skill">
                        <option value="feeding" <?= $edit['skill'] == 'feeding' ? 'selected' : '' ?>>Кормление</option>
                        <option value="walking" <?= $edit['skill'] == 'walking' ? 'selected' : '' ?>>Выгул</option>
                        <option value="medical" <?= $edit['skill'] == 'medical' ? 'selected' : '' ?>>Медицина</option>
                        <option value="cleaning" <?= $edit['skill'] == 'cleaning' ? 'selected' : '' ?>>Уборка</option>
                    </select>
                </div>
                <div class="form-group"><label>Фото (ссылка):</label><br><input type="text" name="photo_url" value="<?= htmlspecialchars($edit['photo_url']) ?>"></div>
                <button type="submit" name="edit" class="btn">💾 Сохранить</button>
                <a href="volunteers_edit.php?token=<?= urlencode($token) ?>" class="btn btn-gray">Отмена</a>
            </form>
        </div>
    <?php endif; ?>

    <h2>📋 Список волонтёров</h2>
    <div style="overflow-x: auto;">
        <table style="width: 100%;">
            <thead>
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Телефон</th>
                <th>Навык</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($volunteers as $vol): ?>
                <tr>
                    <td><?= $vol['id'] ?></td>
                    <td><?= htmlspecialchars($vol['full_name']) ?></td>
                    <td><?= $vol['phone'] ?></td>
                    <td>
                        <?php
                        $skill_rus = '';
                        if ($vol['skill'] == 'feeding') $skill_rus = 'Кормление';
                        if ($vol['skill'] == 'walking') $skill_rus = 'Выгул';
                        if ($vol['skill'] == 'medical') $skill_rus = 'Медицина';
                        if ($vol['skill'] == 'cleaning') $skill_rus = 'Уборка';
                        echo $skill_rus;
                        ?>
                    </td>
                    <td>
                        <a href="volunteers_edit.php?edit=<?= $vol['id'] ?>&token=<?= urlencode($token) ?>" class="btn btn-gray">Изменить</a>
                        <a href="volunteers_edit.php?delete=<?= $vol['id'] ?>&token=<?= urlencode($token) ?>" class="btn btn-gray" onclick="return confirm('Удалить?')">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>