<?php
require_once '../model/models.php';

$filter = $_GET['species'] ?? 'all';

if ($filter == 'cat') {
    $stmt = $pdo->prepare("SELECT * FROM animals WHERE species = 'кот' OR species = 'кошка'");
} elseif ($filter == 'dog') {
    $stmt = $pdo->prepare("SELECT * FROM animals WHERE species = 'собака'");
} else {
    $stmt = $pdo->prepare("SELECT * FROM animals");
}

$stmt->execute();
$animals = $stmt->fetchAll();
?>
<!doctype html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Наши животные</title><link rel="stylesheet" href="../css/main.css"></head>
<body>
<div class="header"><h1>Наши <span>животные</span></h1><p>Выберите друга</p></div>
<div style="max-width:1200px; margin:0 auto; padding:0 20px;">
    <div class="filter-bar" style="display:flex; justify-content:center; gap:15px; margin:30px auto;">
        <a href="?species=all" class="filter-btn">Все</a>
        <a href="?species=cat" class="filter-btn">Кошки</a>
        <a href="?species=dog" class="filter-btn">Собаки</a>
    </div>
    <div class="result-count" style="text-align:center; margin-bottom:20px;">Животных: <?= count($animals) ?></div>
    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:30px;">
        <?php foreach ($animals as $animal): ?>
            <div class="card">
                <img src="<?= $animal['photo_url'] ?>" class="card-img-top">
                <div class="card-body"><h3><?= $animal['name'] ?></h3><p><?= $animal['species'] ?> • <?= $animal['age'] ?> мес.<br>Порода: <?= $animal['breed'] ?></p>
                    <div style="display:flex; gap:8px; justify-content:center; margin-top:10px;"><a href="moreDetails.php?id=<?= $animal['id'] ?>" class="btn" style="background:#8a9a8a;">Подробнее</a><a href="treatment.php?id=<?= $animal['id'] ?>" class="btn" style="background:#8a9a8a;">Лечение</a></div>
                    <div style="margin-top:10px;"><a href="adopt_form.php?id=<?= $animal['id'] ?>" class="btn">Усыновить</a></div>
                </div></div>
        <?php endforeach; ?>
    </div>
    <div style="text-align:center; margin:40px 0;"><a href="foundation.php" class="btn" style="background:#8a9a8a;">На главную</a></div>
</div>
<div class="footer"><p><a href="../admin/admin_login.php">Админ-панель</a></p></div>
</body>
</html>