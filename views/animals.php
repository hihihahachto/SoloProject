<?php
require_once '../model/models.php';

$animals = selectAnimals($pdo);
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Наши животные</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card { height: 100%; }
        .card-img-top { height: 250px; object-fit: cover; }
        .btn-link { background-color: #666; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 2px; font-size: 12px; }
        .btn-adopt { background-color: #28a745; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 2px; font-size: 12px; }
        .back-link { background-color: #666; color: white; padding: 10px 20px; text-decoration: none; border-radius: 10px; display: inline-block; }
    </style>
</head>
<body>

<div class="container mt-3">
    <h1 class="text-center">Наши животные</h1>

    <div class="row">
        <?php foreach ($animals as $animal): ?>
            <div class="col-md-3 col-sm-4 col-6 mb-3">
                <div class="card">
                    <?php if ($animal['photo_url']): ?>
                        <img src="<?= $animal['photo_url'] ?>" class="card-img-top">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5><?= $animal['name'] ?></h5>
                        <p>
                            <?= $animal['species'] ?><br>
                            <?= $animal['age'] ?> мес.<br>
                            Порода: <?= $animal['breed'] ?><br><br>
                            <a href="moreDetails.php?id=<?= $animal['id'] ?>" class="btn-link">Подробнее</a>
                            <a href="treatment.php?id=<?= $animal['id'] ?>" class="btn-link">Лечение</a>
                            <a href="adopt_form.php?id=<?= $animal['id'] ?>" class="btn-adopt">Усыновить</a>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-3">
        <a href="foundation.php" class="back-link">На главную</a>
    </div>
</div>

</body>
</html>