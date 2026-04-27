<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}

require_once '../model/models.php';

// Удаление
if (isset($_GET['delete'])) {
    deleteVolunteer($pdo, $_GET['delete']);
    header('Location: volunteers_edit.php');
    exit;
}

// Добавление
if (isset($_POST['add'])) {
    $photo_url = $_POST['photo_url'] ?? '';
    addVolunteer($pdo, $_POST['full_name'], $_POST['phone'], $_POST['skill'], $photo_url);
    header('Location: volunteers_edit.php');
    exit;
}

// Редактирование
if (isset($_POST['edit'])) {
    updateVolunteer($pdo, $_POST['id'], $_POST['full_name'], $_POST['phone'], $_POST['skill'], $_POST['photo_url']);
    header('Location: volunteers_edit.php');
    exit;
}

$volunteers = selectVolunteers($pdo);
$edit = getVolunteerById($pdo, $_GET['edit']);
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
        .btn { background: #2e7d32; color: white; padding: 5px 12px; border-radius: 20px; text-decoration: none; display: inline-block; margin: 2px; border: none; cursor: pointer; }
        .btn-gray { background: #6c757d; }
        .form-group { margin-bottom: 15px; }
        .form-section { background: #f9fbf7; padding: 20px; border-radius: 15px; margin-bottom: 30px; }
    </style>
</head>
<body style="background: #f0f7f0;">

<div class="container">
    <h1 style="color: #1a5a1e;">🙋 Волонтёры</h1>
    <a href="admin_panel.php" class="btn btn-gray">← Назад</a>

    <!-- ФОРМА ДОБАВЛЕНИЯ -->
    <div class="form-section">
        <h3>➕ Добавить волонтёра</h3>
        <form method="POST">
            <div class="form-group">
                <label>ФИО:</label><br>
                <input type="text" name="full_name" required>
            </div>
            <div class="form-group"><label>Телефон:</label><br><input type="text" name="phone" required></div>
            <div class="form-group">
                <label>Навык:</label><br>
                <select name="skill">
                    <option value="feeding">Кормление</option>
                    <option value="walking">Выгул</option>
                    <option value="medical">Медицина</option>
                    <option value="cleaning">Уборка</option>
                    <option value="admin">Администрирование</option>
                </select>
            </div>
            <div class="form-group"><label>Фото (ссылка):</label><br><input type="text" name="photo_url"></div>
            <button type="submit" name="add" class="btn">➕ Добавить</button>
        </form>
    </div>

    <!-- ФОРМА РЕДАКТИРОВАНИЯ -->
    <?php if ($edit): ?>
        <div class="form-section">
            <h3>✏️ Редактировать волонтёра</h3>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $edit['id'] ?>">
                <div class="form-group">
                    <label>ФИО:</label><br>
                    <input type="text" name="full_name" value="<?= htmlspecialchars($edit['full_name']) ?>" required>
                </div>
                <div class="form-group"><label>Телефон:</label><br><input type="text" name="phone" value="<?= htmlspecialchars($edit['phone']) ?>" required></div>
                <div class="form-group">
                    <label>Навык:</label><br>
                    <select name="skill">
                        <option value="feeding" <?= $edit['skill'] == 'feeding' ? 'selected' : '' ?>>Кормление</option>
                        <option value="walking" <?= $edit['skill'] == 'walking' ? 'selected' : '' ?>>Выгул</option>
                        <option value="medical" <?= $edit['skill'] == 'medical' ? 'selected' : '' ?>>Медицина</option>
                        <option value="cleaning" <?= $edit['skill'] == 'cleaning' ? 'selected' : '' ?>>Уборка</option>
                        <option value="admin" <?= $edit['skill'] == 'admin' ? 'selected' : '' ?>>Администрирование</option>
                    </select>
                </div>
                <div class="form-group"><label>Фото (ссылка):</label><br><input type="text" name="photo_url" value="<?= htmlspecialchars($edit['photo_url']) ?>"></div>
                <button type="submit" name="edit" class="btn">💾 Сохранить</button>
                <a href="volunteers_edit.php" class="btn btn-gray">Отмена</a>
            </form>
        </div>
    <?php endif; ?>

    <!-- СПИСОК ВОЛОНТЁРОВ -->
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
                        $skill_ru = [
                                'feeding' => 'Кормление',
                                'walking' => 'Выгул',
                                'medical' => 'Медицина',
                                'cleaning' => 'Уборка',
                                'admin' => 'Администрирование'
                        ][$vol['skill']] ?? $vol['skill'];
                        echo $skill_ru;
                        ?>
                    </td>
                    <td>
                        <a href="volunteers_edit.php?edit=<?= $vol['id'] ?>" class="btn btn-gray">Изменить</a>
                        <a href="volunteers_edit.php?delete=<?= $vol['id'] ?>" class="btn btn-gray" onclick="return confirm('Удалить?')">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>