<?php
require_once 'database.php';
require_once '../SoloProject/api/controller/AnimalController.php';

$id = $_GET['id'];
$details = getAnimalDetails($pdo, $id);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лечение</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="header"><h1>Лечение</h1></div>
<div style="max-width:800px; margin:40px auto; background:white; padding:40px; border-radius:20px;">
    <?php if ($details && $details['treatment_text']): ?>
        <?= nl2br($details['treatment_text']) ?>
    <?php else: ?>
        <p>Информация о лечении пока не добавлена</p>
    <?php endif; ?>
    <div style="text-align:center; margin-top:30px;">
        <a href="animals.php" class="btn">Назад</a>
    </div>
</div>
<div class="footer"><p><a href="foundation.php">На главную</a></p></div>
</body>
</html>