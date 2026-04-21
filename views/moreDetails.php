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
    <title><?= $animal['name'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; padding: 20px; }
        .container-custom { max-width: 1000px; margin: 0 auto; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; }
        .left-column { padding: 30px; text-align: center; }
        .right-column { padding: 30px; background-color: #fafafa; border-left: 1px solid #ddd; }
        .animal-photo { width: 100%; height: 350px; object-fit: cover; border-radius: 15px; }
        .animal-name { font-size: 32px; font-weight: bold; margin: 20px 0 10px; color: #333; }
        .animal-info { text-align: left; margin-top: 20px; }
        .info-line { margin-bottom: 10px; font-size: 16px; }
        .info-label { font-weight: bold; }
        .story-title { font-size: 24px; font-weight: bold; margin-bottom: 20px; border-bottom: 2px solid #ccc; display: inline-block; padding-bottom: 5px; }
        .story-text { font-size: 16px; line-height: 1.6; color: #333; margin-top: 20px; }
        .back-btn { padding: 20px 0 30px 0; text-align: center; clear: both; }
        .back-btn a { background-color: #666; color: white; padding: 10px 30px; text-decoration: none; border-radius: 30px; display: inline-block; }
        @media (max-width: 768px) { .right-column { border-left: none; border-top: 1px solid #ddd; } }
    </style>
</head>
<body>

<div class="container-custom">
    <div class="row g-0">
        <div class="col-md-6 left-column">
            <?php if (!empty($animal['photo_url'])): ?>
                <img src="<?= $animal['photo_url'] ?>" class="animal-photo">
            <?php endif; ?>
            <div class="animal-name"><?= $animal['name'] ?></div>
            <div class="animal-info">
                <div class="info-line"><span class="info-label">Вид:</span> <?= $animal['species'] ?></div>
                <div class="info-line"><span class="info-label">Порода:</span> <?= $animal['breed'] ?></div>
                <div class="info-line"><span class="info-label">Возраст:</span> <?= $animal['age'] ?> мес.</div>
                <div class="info-line"><span class="info-label">Статус:</span> <?= $animal['status'] ?></div>
                <?php if ($details && $details['character_desc']): ?>
                    <div class="info-line"><span class="info-label">Характер:</span> <?= $details['character_desc'] ?></div>
                <?php endif; ?>
                <?php if ($details && $details['health_desc']): ?>
                    <div class="info-line"><span class="info-label">Здоровье:</span> <?= $details['health_desc'] ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-6 right-column">
            <div class="story-title">История</div>
            <div class="story-text">
                <?php if ($details && $details['text']): ?>
                    <?= nl2br($details['text']) ?>
                <?php else: ?>
                    История пока не добавлена
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="back-btn">
        <a href="animals.php">← Назад</a>
    </div>
</div>

</body>
</html>