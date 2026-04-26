<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}

require_once '../model/models.php';

// Удаление
if (isset($_GET['delete'])) {
    deleteAnimal($pdo, $_GET['delete']);
    header('Location: animals_edit.php');
    exit;
}

// Редактирование основной информации
if (isset($_POST['edit'])) {
    updateAnimal($pdo, $_POST['id'], $_POST['name'], $_POST['species'], $_POST['breed'], $_POST['age'], $_POST['status'], $_POST['photo_url'], $_POST['character_desc'], $_POST['health_desc']);
    header('Location: animals_edit.php');
    exit;
}

// Добавление
if (isset($_POST['add'])) {
    $animal_id = addAnimal($pdo, $_POST['name'], $_POST['species'], $_POST['breed'], $_POST['age'], $_POST['status'], $_POST['photo_url']);

    $sql = "INSERT INTO animal_details (animal_id, character_desc, health_desc) VALUES ('$animal_id', '{$_POST['character_desc']}', '{$_POST['health_desc']}')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    header('Location: animals_edit.php');
    exit;
}

// Обновление лечения
if (isset($_POST['update_treatment'])) {
    $animal_id = $_POST['animal_id'] ?? 0;
    $treatment_text = $_POST['treatment_text'] ?? '';
    if ($animal_id > 0) {
        updateTreatment($pdo, $animal_id, $treatment_text);
    }
    header('Location: animals_edit.php');
    exit;
}

$animals = selectAnimals($pdo);
$edit = isset($_GET['edit']) ? getAnimalById($pdo, $_GET['edit']) : null;
$edit_details = $edit ? detailsAnimal($pdo, $edit['id']) : null;
$treatment_animal_id = isset($_GET['treatment']) ? (int)$_GET['treatment'] : 0;
$treatment = $treatment_animal_id > 0 ? getTreatment($pdo, $treatment_animal_id) : null;
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
    <a href="admin_panel.php" class="btn btn-gray">← Назад в панель</a>

    <!-- ФОРМА РЕДАКТИРОВАНИЯ ЛЕЧЕНИЯ -->
    <?php if ($treatment_animal_id > 0): ?>
        <div class="form-section">
            <h3>💊 Редактировать лечение</h3>
            <form method="POST">
                <input type="hidden" name="animal_id" value="<?= $treatment_animal_id ?>">
                <div class="form-group">
                    <label>Информация о лечении:</label>
                    <textarea name="treatment_text" rows="10" style="width:100%;"><?= htmlspecialchars($treatment['treatment_text'] ?? '') ?></textarea>
                </div>
                <button type="submit" name="update_treatment" class="btn">💾 Сохранить лечение</button>
                <a href="animals_edit.php" class="btn btn-gray">Отмена</a>
            </form>
        </div>
    <?php endif; ?>

    <!-- ФОРМА ДОБАВЛЕНИЯ -->
    <div class="form-section">
        <h3>➕ Добавить новое животное</h3>
        <form method="POST">
            <div class="form-group">
                <label>Кличка:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Вид:</label>
                <select name="species">
                    <option value="кот">Кот</option>
                    <option value="кошка">Кошка</option>
                    <option value="собака">Собака</option>
                </select>
            </div>
            <div class="form-group">
                <label>Порода:</label>
                <input type="text" name="breed">
            </div>
            <div class="form-group">
                <label>Возраст (мес):</label>
                <input type="number" name="age">
            </div>
            <div class="form-group">
                <label>Статус:</label>
                <select name="status">
                    <option value="waiting">Ждёт хозяина</option>
                    <option value="adopted">Усыновлён</option>
                    <option value="treatment">На лечении</option>
                </select>
            </div>
            <div class="form-group">
                <label>Фото (ссылка):</label>
                <input type="text" name="photo_url" placeholder="https://...">
            </div>
            <div class="form-group">
                <label>Характер:</label>
                <textarea name="character_desc" rows="3" style="width:100%;"></textarea>
            </div>
            <div class="form-group">
                <label>Здоровье:</label>
                <textarea name="health_desc" rows="3" style="width:100%;"></textarea>
            </div>
            <button type="submit" name="add" class="btn">➕ Добавить животное</button>
        </form>
    </div>

    <!-- ФОРМА РЕДАКТИРОВАНИЯ -->
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
                        <option value="adopted" <?= $edit['status'] == 'adopted' ? 'selected' : '' ?>>Усыновлён</option>
                        <option value="treatment" <?= $edit['status'] == 'treatment' ? 'selected' : '' ?>>На лечении</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Фото (ссылка):</label>
                    <input type="text" name="photo_url" value="<?= htmlspecialchars($edit['photo_url']) ?>">
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
                <a href="animals_edit.php" class="btn btn-gray">Отмена</a>
            </form>
        </div>
    <?php endif; ?>

    <!-- СПИСОК ЖИВОТНЫХ -->
    <h2>📋 Список животных</h2>
    <div style="overflow-x: auto;">
        <table style="width: 100%;">
            <thead>
            <tr><th>ID</th><th>Кличка</th><th>Вид</th><th>Порода</th><th>Возраст</th><th>Статус</th><th>Действия</th></tr>
            </thead>
            <tbody>
            <?php foreach ($animals as $animal): ?>
                <tr>
                    <td><?= $animal['id'] ?></td>
                    <td><?= htmlspecialchars($animal['name']) ?></td>
                    <td><?= $animal['species'] ?></td>
                    <td><?= $animal['breed'] ?></td>
                    <td><?= $animal['age'] ?></td>
                    <td>
                        <?php
                        $status_ru = [
                            'waiting' => 'Ждёт хозяина',
                            'adopted' => 'Усыновлён',
                            'treatment' => 'На лечении'
                        ][$animal['status']] ?? $animal['status'];
                        echo $status_ru;
                        ?>
                    </td>
                    <td>
                        <a href="animals_edit.php?edit=<?= $animal['id'] ?>" class="btn btn-gray btn-small">Изменить</a>
                        <a href="animals_edit.php?treatment=<?= $animal['id'] ?>" class="btn btn-gray btn-small">Лечение</a>
                        <a href="animals_edit.php?delete=<?= $animal['id'] ?>" class="btn btn-gray btn-small" onclick="return confirm('Удалить?')">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>