<?php
require_once '../model/models.php';

$id = $_GET['id'] ?? 0;

if ($id == 0) {
    die("Ошибка: ID животного не указан");
}

$stmt = $pdo->prepare("SELECT * FROM animals WHERE id = ?");
$stmt->execute([$id]);
$animal = $stmt->fetch();

if (!$animal) {
    die("Животное не найдено");
}

$details = detailsAnimal($pdo, $id);
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лечение - <?= $animal['name'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; padding: 20px; }
        .container-custom { max-width: 900px; margin: 0 auto; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); padding: 30px; }
        .animal-name { font-size: 32px; font-weight: bold; margin-bottom: 20px; text-align: center; }
        .treatment-text { font-size: 16px; line-height: 1.6; color: #333; white-space: pre-wrap; }
        .back-btn { margin-top: 30px; text-align: center; }
        .back-btn a { background-color: #666; color: white; padding: 10px 30px; text-decoration: none; border-radius: 30px; display: inline-block; }
    </style>
</head>
<body>

<div class="container-custom">
    <div class="animal-name"><?= $animal['name'] ?></div>

    <?php if ($details && $details['treatment_text']): ?>
        <div class="treatment-text"><?= nl2br($details['treatment_text']) ?></div>
    <?php else: ?>
        <p style="text-align: center; color: #999;">Информация о лечении пока не добавлена</p>
    <?php endif; ?>

    <div class="back-btn">
        <a href="animals.php">← Назад</a>
    </div>
</div>

</body>
</html>