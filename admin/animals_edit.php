<?php
// Сначала подключаем БД
require_once '../model/database.php';

// Проверяем токен
$token = $_GET['token'] ?? '';
$sql = "SELECT * FROM admins WHERE token = :token";
$stmt = $pdo->prepare($sql);
$stmt->execute([':token' => $token]);
$admin = $stmt->fetch();
if (!$admin) {
    die('Доступ запрещён. Авторизуйтесь заново.');
}

require_once '../model/AnimalController.php';

if (isset($_GET['delete'])) {
    deleteAnimal($pdo, $_GET['delete']);
    header('Location: animals_edit.php?token=' . urlencode($token));
    exit;
}

if (isset($_POST['edit'])) {
    updateAnimal($pdo, $_POST['id'], $_POST['name'], $_POST['species'], $_POST['breed'], $_POST['age'], $_POST['status'], $_POST['photo_url']);
    updateAnimalDetails($pdo, $_POST['id'], $_POST['character_desc'], $_POST['health_desc']);
    header('Location: animals_edit.php?token=' . urlencode($token));
    exit;
}

if (isset($_POST['add'])) {
    addAnimal($pdo, $_POST['name'], $_POST['species'], $_POST['breed'], $_POST['age'], $_POST['status'], $_POST['photo_url']);
    header('Location: animals_edit.php?token=' . urlencode($token));
    exit;
}

if (isset($_POST['update_treatment'])) {
    $animal_id = $_POST['animal_id'];
    $treatment_text = $_POST['treatment_text'];

    $sql = "SELECT * FROM animal_details WHERE animal_id = :animal_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':animal_id' => $animal_id]);
    $exists = $stmt->fetch();

    if ($exists) {
        $sql = "UPDATE animal_details SET treatment_text = :treatment_text WHERE animal_id = :animal_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':treatment_text' => $treatment_text, ':animal_id' => $animal_id]);
    } else {
        $sql = "INSERT INTO animal_details (animal_id, treatment_text) VALUES (:animal_id, :treatment_text)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':animal_id' => $animal_id, ':treatment_text' => $treatment_text]);
    }
    header('Location: animals_edit.php?token=' . urlencode($token));
    exit;
}

$animals = getAllAnimals($pdo);

$edit = null;
if (isset($_GET['edit'])) {
    $edit = getAnimalById($pdo, $_GET['edit']);
    $edit_details = getAnimalDetails($pdo, $edit['id']);
}

$treatment = null;
if (isset($_GET['treatment'])) {
    $treatment = getAnimalDetails($pdo, $_GET['treatment']);
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление животными</title>
    <link rel="stylesheet" href="../css/main.css">
    <style>
        .container { max-width: 1200px; margin: 40px auto; background: white; padding: 30px; border-radius: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #7eb07e; color: white; }
        tr:hover { background: #f5faf2; }
        input, select, textarea { padding: 8px 12px; border-radius: 8px; border: 1px solid #ccc; width: 100%; }
        .btn { background: #7eb07e; color: white; padding: 8px 20px; border-radius: 25px; text-decoration: none; display: inline-block; margin: 2px; border: none; cursor: pointer; }
        .btn-gray { background: #8a9a8a; }
        .btn-small { padding: 5px 12px; font-size: 12px; }
        .form-group { margin-bottom: 15px; }
        .form-section { background: #f9fbf7; padding: 20px; border-radius: 15px; margin-bottom: 30px; }
        .form-section h3 { color: #5a8a5a; margin-bottom: 15px; }
    </style>
</head>
<body style="background: #f0f7f0;">

<div class="container">
    <h1 style="color: #5a8a5a;">🐾 Управление животными</h1>
    <a href="admin_panel.php?token=<?= urlencode($token) ?>">← Назад в панель</a>

    <?php if (isset($_GET['treatment'])): ?>
        <div class="form-section">
            <h3>💊 Редактировать лечение</h3>
            <form method="POST">
                <input type="hidden" name="animal_id" value="<?= $_GET['treatment'] ?>">
                <div class="form-group">
                    <label>Информация о лечении:</label>
                    <textarea name="treatment_text" rows="10" style="width:100%;"><?= htmlspecialchars($treatment['treatment_text'] ?? '') ?></textarea>
                </div>
                <button type="submit" name="update_treatment" class="btn">💾 Сохранить лечение</button>
                <a href="animals_edit.php?token=<?= urlencode($token) ?>" class="btn btn-gray">Отмена</a>
            </form>
        </div>
    <?php endif; ?>

    <!-- добавление -->
    <?php if (!$edit && !isset($_GET['treatment'])): ?>
        <div class="form-section">
            <h3>➕ Добавить новое животное</h3>
            <form method="POST">
                <div class="form-group"><label>Кличка:</label><input type="text" name="name" required></div>
                <div class="form-group">
                    <label>Вид:</label>
                    <select name="species">
                        <option value="кот">Кот</option>
                        <option value="кошка">Кошка</option>
                        <option value="собака">Собака</option>
                    </select>
                </div>
                <div class="form-group"><label>Порода:</label><input type="text" name="breed"></div>
                <div class="form-group"><label>Возраст (мес):</label><input type="number" name="age"></div>
                <div class="form-group">
                    <label>Статус:</label>
                    <select name="status">
                        <option value="waiting">Ждёт хозяина</option>
                        <option value="adopted">Усыновлен</option>
                        <option value="treatment">На лечении</option>
                    </select>
                </div>
                <div class="form-group"><label>Фото (ссылка):</label><input type="text" name="photo_url" placeholder="https://..."></div>
                <button type="submit" name="add" class="btn">➕ Добавить животное</button>
            </form>
        </div>
    <?php endif; ?>

    <?php if ($edit): ?>
        <div class="form-section">
            <h3>✏️ Редактировать животное</h3>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $edit['id'] ?>">
                <div class="form-group">
                    <label>Кличка:</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($edit['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Вид:</label>
                    <select name="species">
                        <option value="кот" <?= $edit['species'] == 'кот' ? 'selected' : '' ?>>Кот</option>
                        <option value="кошка" <?= $edit['species'] == 'кошка' ? 'selected' : '' ?>>Кошка</option>
                        <option value="собака" <?= $edit['species'] == 'собака' ? 'selected' : '' ?>>Собака</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Порода:</label>
                    <input type="text" name="breed" value="<?= htmlspecialchars($edit['breed']) ?>">
                </div>
                <div class="form-group">
                    <label>Возраст (мес):</label>
                    <input type="number" name="age" value="<?= $edit['age'] ?>">
                </div>
                <div class="form-group">
                    <label>Статус:</label>
                    <select name="status">
                        <option value="waiting" <?= $edit['status'] == 'waiting' ? 'selected' : '' ?>>Ждёт хозяина</option>
                        <option value="adopted" <?= $edit['status'] == 'adopted' ? 'selected' : '' ?>>Усыновлен</option>
                        <option value="treatment" <?= $edit['status'] == 'treatment' ? 'selected' : '' ?>>На лечении</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Фото (ссылка):</label><input type="text" name="photo_url" value="<?= htmlspecialchars($edit['photo_url']) ?>">
                </div>
                <div class="form-group">
                    <label>Характер:</label>
                    <textarea name="character_desc" rows="3" style="width:100%;"><?= htmlspecialchars($edit_details['character_desc'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label>Здоровье:</label>
                    <textarea name="health_desc" rows="3" style="width:100%;"><?= htmlspecialchars($edit_details['health_desc'] ?? '') ?></textarea>
                </div>
                <button type="submit" name="edit" class="btn">💾 Сохранить</button>
                <a href="animals_edit.php?token=<?= urlencode($token) ?>" class="btn btn-gray">Отмена</a>
            </form>
        </div>
    <?php endif; ?>

    <h2>📋 Список животных</h2>
    <div style="overflow-x: auto;">
        <table style="width: 100%;">
            <thead>
            <tr>
                <th>ID</th>
                <th>Кличка</th>
                <th>Вид</th>
                <th>Порода</th>
                <th>Возраст</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($animals as $animal): ?>
                <tr>
                    <td><?= $animal['id'] ?></td>
                    <td><?= htmlspecialchars($animal['name']) ?></td>
                    <td><?= $animal['species'] ?></td>
                    <td><?= $animal['breed'] ?></td>
                    <td><?= $animal['age'] ?></td>
                    <td><?= $animal['status'] ?></td>
                    <td>
                        <a href="animals_edit.php?edit=<?= $animal['id'] ?>&token=<?= urlencode($token) ?>" class="btn btn-gray btn-small">Изменить</a>
                        <a href="animals_edit.php?treatment=<?= $animal['id'] ?>&token=<?= urlencode($token) ?>" class="btn btn-gray btn-small">Лечение</a>
                        <a href="animals_edit.php?delete=<?= $animal['id'] ?>&token=<?= urlencode($token) ?>" class="btn btn-gray btn-small" onclick="return confirm('Удалить?')">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>