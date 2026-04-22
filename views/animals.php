<?php
require_once '../model/models.php';

// Получаем выбранный фильтр
$species_filter = $_GET['species'] ?? 'all';

// Формируем запрос с фильтром
if ($species_filter == 'all') {
    $animals = selectAnimals($pdo);
} elseif ($species_filter == 'cat') {
    // Ищем и котов, и кошек
    $stmt = $pdo->prepare("SELECT * FROM animals WHERE species = 'кот' OR species = 'кошка'");
    $stmt->execute();
    $animals = $stmt->fetchAll();
} elseif ($species_filter == 'dog') {
    $stmt = $pdo->prepare("SELECT * FROM animals WHERE species = 'собака'");
    $stmt->execute();
    $animals = $stmt->fetchAll();
} else {
    $animals = selectAnimals($pdo);
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Наши животные</title>
    <link rel="stylesheet" href="../css/main.css">
    <style>
        .filter-bar {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 30px auto;
            flex-wrap: wrap;
        }
        .filter-btn {
            background: #e0ecd0;
            color: #4a6e4a;
            padding: 10px 25px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .filter-btn:hover {
            background: #c8e0c0;
            transform: translateY(-2px);
        }
        .filter-btn.active {
            background: #7eb07e;
            color: white;
        }
        .result-count {
            text-align: center;
            margin-bottom: 20px;
            color: #6ba06b;
            font-size: 0.9rem;
        }
        .card-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .btn-small {
            padding: 6px 14px;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Наши <span>животные</span></h1>
    <p>Выберите друга, который ждёт вас</p>
</div>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">


    <div class="filter-bar">
        <a href="?species=all" class="filter-btn <?= $species_filter == 'all' ? 'active' : '' ?>">Все</a>
        <a href="?species=cat" class="filter-btn <?= $species_filter == 'cat' ? 'active' : '' ?>">Кошки</a>
        <a href="?species=dog" class="filter-btn <?= $species_filter == 'dog' ? 'active' : '' ?>">Собаки</a>
    </div>

    <?php if ($species_filter == 'cat'): ?>
        <div class="result-count">Показаны кошки (<?= count($animals) ?>)</div>
    <?php elseif ($species_filter == 'dog'): ?>
        <div class="result-count">Показаны собаки (<?= count($animals) ?>)</div>
    <?php else: ?>
        <div class="result-count">Все животные (<?= count($animals) ?>)</div>
    <?php endif; ?>

    <div class="cards-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
        <?php foreach ($animals as $animal): ?>
            <div class="card">
                <?php if ($animal['photo_url']): ?>
                    <img src="<?= $animal['photo_url'] ?>" class="card-img-top" alt="<?= $animal['name'] ?>">
                <?php else: ?>
                    <img src="https://images.pexels.com/photos/617278/pexels-photo-617278.jpeg?auto=compress&cs=tinysrgb&w=300" class="card-img-top" alt="Животное">
                <?php endif; ?>
                <div class="card-body">
                    <h3 class="card-title"><?= $animal['name'] ?></h3>
                    <p class="card-text">
                        <?= $animal['species'] ?> • <?= $animal['age'] ?> мес.<br>
                        Порода: <?= $animal['breed'] ?: 'Неизвестно' ?>
                    </p>
                    <div class="card-buttons">
                        <a href="moreDetails.php?id=<?= $animal['id'] ?>" class="btn btn-small" style="background: #8a9a8a;">Подробнее</a>
                        <a href="treatment.php?id=<?= $animal['id'] ?>" class="btn btn-small" style="background: #8a9a8a;">Лечение</a>
                        <a href="adopt_form.php?id=<?= $animal['id'] ?>" class="btn btn-small">Усыновить</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($animals)): ?>
        <div style="text-align: center; padding: 50px; background: white; border-radius: 20px;">
            <p>😔 Животных этого вида пока нет</p>
            <a href="?species=all" class="btn">Посмотреть всех</a>
        </div>
    <?php endif; ?>

    <div style="text-align: center; margin: 40px 0;">
        <a href="foundation.php" class="btn" style="background: #8a9a8a;">← На главную</a>
    </div>
</div>

<div class="footer">
    <p>🐾 Приют «Вторая жизнь» — дарим надежду тем, кто в ней нуждается</p>
    <p><a href="../admin/admin_login.php">Админ-панель</a></p>
</div>

</body>
</html>