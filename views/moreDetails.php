<?php
require_once '../model/models.php';

$id = $_GET['id'] ?? 0;
if ($id == 0) die("Ошибка: ID не указан");

$stmt = $pdo->prepare("SELECT * FROM animals WHERE id = ?");
$stmt->execute([$id]);
$animal = $stmt->fetch();
if (!$animal) die("Животное не найдено");

$details = detailsAnimal($pdo, $id);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $animal['name'] ?></title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>

<div class="header">
    <h1><?= $animal['name'] ?></h1>
</div>

<div style="max-width: 1000px; margin: 40px auto; background: white; border-radius: 20px; overflow: hidden; display: flex; flex-wrap: wrap;">
    <div style="flex:1; min-width: 300px;">
        <?php if ($animal['photo_url']): ?>
            <img src="<?= $animal['photo_url'] ?>" style="width:100%; height:100%; object-fit:cover;">
        <?php endif; ?>
    </div>
    <div style="flex:1; padding: 30px;">
        <h2 style="color:#1a5a1e;"><?= $animal['name'] ?></h2>
        <p><strong>Вид:</strong> <?= $animal['species'] ?></p>
        <p><strong>Порода:</strong> <?= $animal['breed'] ?></p>
        <p><strong>Возраст:</strong> <?= $animal['age'] ?> мес.</p>
        <p><strong>Статус:</strong> <?= $animal['status'] ?></p>
        <?php if ($details && $details['character_desc']): ?>
            <p><strong>Характер:</strong> <?= $details['character_desc'] ?></p>
        <?php endif; ?>
        <?php if ($details && $details['health_desc']): ?>
            <p><strong>Здоровье:</strong> <?= $details['health_desc'] ?></p>
        <?php endif; ?>

        <div style="background: #e8f5e9; padding: 20px; border-radius: 15px; margin-top: 20px;">
            <h3>📖 История</h3>
            <p><?= $details && $details['text'] ? nl2br($details['text']) : 'История пока не добавлена' ?></p>
        </div>

        <div style="margin-top: 30px;">
            <a href="animals.php" class="btn" style="background:#6c757d;">← Назад</a>
            <a href="adopt_form.php?id=<?= $animal['id'] ?>" class="btn">Усыновить</a>
        </div>
    </div>
</div>

<div class="footer">
    <p><a href="foundation.php">На главную</a></p>
</div>

</body>
</html>