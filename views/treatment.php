<?php
require_once '../model/models.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM animals WHERE id = $id");
$stmt->execute();
$animal = $stmt->fetch();
$details = detailsAnimal($pdo, $id);

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лечение - <?= $animal['name'] ?></title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <div class="header">
        <h1>Лечение <span><?= $animal['name'] ?></span></h1>
    </div>
    <div style="max-width:800px; margin:40px auto; background:white; padding:40px; border-radius:20px;">
        <?= nl2br($details['treatment_text']) ?>
        <div style="text-align:center; margin-top:30px;"><a href="animals.php" class="btn" style="background:#6c757d;">Назад</a></div>
    </div>
<div class="footer"><p><a href="foundation.php">На главную</a></p>
</div>
</body>
</html>