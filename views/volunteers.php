<?php
require_once '../model/models.php';

$volunteers = selectVolunteers($pdo);
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Наши волонтёры</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card { height: 100%; }
        .card-img-top { height: 250px; object-fit: cover; }
        .btn-custom { background-color: #666; color: white; padding: 10px 20px; text-decoration: none; border-radius: 10px; display: inline-block; }
        .back-link { background-color: #666; color: white; padding: 10px 20px; text-decoration: none; border-radius: 10px; display: inline-block; }
    </style>
</head>
<body>

<div class="container mt-3">
    <h1 class="text-center">Наши волонтёры</h1>

    <div class="row">
        <?php foreach ($volunteers as $volunteer): ?>
            <div class="col-md-3 col-sm-4 col-6 mb-3">
                <div class="card">
                    <?php if ($volunteer['photo_url']): ?>
                        <img src="<?= $volunteer['photo_url'] ?>" class="card-img-top">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5><?= $volunteer['full_name'] ?></h5>
                        <p>
                            <?= $volunteer['phone'] ?><br>
                            <?= $volunteer['skill'] ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-4">
        <a href="volunteer_form.php" class="btn-custom">Присоединиться к волонтёрам</a>
    </div>

    <div class="text-center mt-3">
        <a href="foundation.php" class="back-link">На главную</a>
    </div>
</div>

</body>
</html>