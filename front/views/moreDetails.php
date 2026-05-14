<?php
require_once 'database.php';
require_once '../SoloProject/api/controller/AnimalController.php';

$id = $_GET['id'];
$animal = getAnimalById($pdo, $id);
$details = getAnimalDetails($pdo, $id);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $animal['name'] ?></title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="header"><h1><?= $animal['name'] ?></h1></div>
<div style="max-width:1000px; margin:40px auto; background:white; border-radius:20px; display:flex; flex-wrap:wrap;">
    <div style="flex:1; min-width:300px;">
        <img src="<?= $animal['photo_url'] ?>" style="width:100%; height:100%; object-fit:cover; border-radius:20px 0 0 20px;">
    </div>
    <div style="flex:1; padding:30px;">
        <p><strong>Вид:</strong> <?= $animal['species'] ?></p>
        <p><strong>Порода:</strong> <?= $animal['breed'] ?></p>
        <p><strong>Возраст:</strong> <?= $animal['age'] ?> мес.</p>
        <p><strong>Статус:</strong> <?= $animal['status'] ?></p>

        <?php if ($details): ?>
            <p><strong>Характер:</strong> <?= $details['character_desc'] ?></p>
            <p><strong>Здоровье:</strong> <?= $details['health_desc'] ?></p>
            <div style="background:#e8f5e9; padding:20px; border-radius:15px;">
                <h3>📖 История</h3>
                <p><?= nl2br($details['story']) ?></p>
            </div>
        <?php else: ?>
            <p><strong>Характер:</strong> Не указан</p>
            <p><strong>Здоровье:</strong> Не указано</p>
        <?php endif; ?>

        <div style="margin-top:30px;">
            <a href="animals.php" class="btn">Назад</a>
            <a href="adopt_form.php?id=<?= $animal['id'] ?>" class="btn">Усыновить</a>
        </div>
    </div>
</div>
<div class="footer"><p><a href="foundation.php">На главную</a></p></div>
</body>
</html>