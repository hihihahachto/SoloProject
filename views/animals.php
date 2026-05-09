<?php
require_once '../model/Database.php';
require_once '../controller/AnimalController.php';

$filter = $_GET['species'] ?? 'all';

if ($filter == 'cat') {
    $sql = "SELECT * FROM animals WHERE species = 'кот' OR species = 'кошка'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $animals = $stmt->fetchAll();
} elseif ($filter == 'dog') {
    $sql = "SELECT * FROM animals WHERE species = 'собака'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $animals = $stmt->fetchAll();
} else {
    $animals = getAllAnimals($pdo);
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Наши животные</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="header">
    <h1>Наши <span>животные</span></h1>
</div>

<div style="max-width:1200px; margin:0 auto; padding:20px;">
    <div style="display:flex; gap:15px; justify-content:center;">
        <a href="?species=all">Все</a>
        <a href="?species=cat">Кошки</a>
        <a href="?species=dog">Собаки</a>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:30px; margin-top:30px;">
        <?php foreach ($animals as $animal): ?>
            <div class="card">
                <img src="<?= $animal['photo_url'] ?>" style="height:200px; width:100%; object-fit:cover;">
                <h3><?= $animal['name'] ?></h3>
                <p><?= $animal['species'] ?> • <?= $animal['age'] ?> мес.</p>
                <div style="display:flex; gap:10px; justify-content:center;">
                    <a href="moreDetails.php?id=<?= $animal['id'] ?>" class="btn">Подробнее</a>
                    <a href="treatment.php?id=<?= $animal['id'] ?>" class="btn">Лечение</a>
                </div>
                <div style="margin-top:10px;">
                    <a href="adopt_form.php?id=<?= $animal['id'] ?>" class="btn">Усыновить</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="footer">
    <p><a href="foundation.php">На главную</a></p>
</div>
</body>
</html>