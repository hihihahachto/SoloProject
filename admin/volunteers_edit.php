<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}

require_once '../model/models.php';

if (isset($_GET['delete'])) {
    deleteVolunteer($pdo, $_GET['delete']);
    header('Location: volunteers_edit.php');
    exit;
}

if ($_POST && isset($_POST['edit'])) {
    updateVolunteer($pdo, $_POST['id'], $_POST['full_name'], $_POST['phone'], $_POST['skill'], $_POST['photo_url']);
    header('Location: volunteers_edit.php');
    exit;
}

$volunteers = selectVolunteers($pdo);
$edit = isset($_GET['edit']) ? getVolunteerById($pdo, $_GET['edit']) : null;
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Волонтёры</title>
    <link rel="stylesheet" href="../css/main.css">
    <style>
        .container { max-width: 1200px; margin: 40px auto; background: white; padding: 30px; border-radius: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #1a5a1e; color: white; }
        tr:hover { background: #f5f5f5; }
        input, select { padding: 8px; border-radius: 8px; border: 1px solid #ccc; }
        .btn { background: #2e7d32; color: white; padding: 5px 12px; border-radius: 20px; text-decoration: none; display: inline-block; margin: 2px; }
        .btn-gray { background: #6c757d; }
        .form-group { margin-bottom: 15px; }
    </style>
</head>
<body style="background: #f0f7f0;">

<div class="container">
    <h1 style="color: #1a5a1e;">🙋 Волонтёры</h1>
    <a href="admin_panel.php" class="btn btn-gray">← Назад</a>

    <?php if ($edit): ?>
        <h2>Редактировать волонтёра</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $edit['id'] ?>">
            <div class="form-group"><label>ФИО:</label><br><input type="text" name="full_name" value="<?= $edit['full_name'] ?>" required></div>
            <div class="form-group"><label>Телефон:</label><br><input type="text" name="phone" value="<?= $edit['phone'] ?>" required></div>
            <div class="form-group">
                <label>Навык:</label><br>
                <select name="skill">
                    <option <?= $edit['skill'] == 'feeding' ? 'selected' : '' ?>>feeding</option>
                    <option <?= $edit['skill'] == 'walking' ? 'selected' : '' ?>>walking</option>
                    <option <?= $edit['skill'] == 'medical' ? 'selected' : '' ?>>medical</option>
                    <option <?= $edit['skill'] == 'cleaning' ? 'selected' : '' ?>>cleaning</option>
                </select>
            </div>
            <div class="form-group"><label>Фото (ссылка):</label><br><input type="text" name="photo_url" value="<?= $edit['photo_url'] ?>"></div>
            <button type="submit" name="edit" class="btn">Сохранить</button>
            <a href="volunteers_edit.php" class="btn btn-gray">Отмена</a>
        </form>
    <?php endif; ?>

    <h2>📋 Список волонтёров</h2>
    <table>
        <tr><th>ID</th><th>ФИО</th><th>Телефон</th><th>Навык</th><th>Действия</th></tr>
        <?php foreach ($volunteers as $vol): ?>
            <tr>
                <td><?= $vol['id'] ?></td>
                <td><?= $vol['full_name'] ?></td>
                <td><?= $vol['phone'] ?></td>
                <td><?= $vol['skill'] ?></td>
                <td>
                    <a href="volunteers_edit.php?edit=<?= $vol['id'] ?>" class="btn btn-gray">✏️</a>
                    <a href="volunteers_edit.php?delete=<?= $vol['id'] ?>" class="btn btn-gray" onclick="return confirm('Удалить?')">🗑️</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>