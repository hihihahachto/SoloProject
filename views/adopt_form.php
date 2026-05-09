<?php
require_once '../model/Database.php';

$id = $_GET['id'];

$sql = "SELECT * FROM animals WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$animal = $stmt->fetch();

if ($_POST) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $sql = "SELECT * FROM adoptions WHERE animal_id = :animal_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':animal_id' => $id]);
    $exists = $stmt->fetch();

    if (!$exists) {
        $sql = "INSERT INTO adoptions (animal_id, adopter_name, adopter_phone, adoption_date) VALUES (:animal_id, :name, :phone, CURDATE())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':animal_id' => $id,
            ':name' => $name,
            ':phone' => $phone
        ]);

        addNotification($pdo, "Новая заявка на усыновление {$animal['name']} от $name", 'adoption');
    }

    echo "<div style='text-align:center; padding:50px;'>
            <div style='background:#e8f5e9; max-width:400px; margin:0 auto; padding:30px; border-radius:20px;'>
                <h2 style='color:green;'>Спасибо, $name!</h2>
                <p>Ваша заявка на усыновление {$animal['name']} отправлена.</p>
                <a href='animals.php' class='btn'>Вернуться</a>
            </div>
          </div>";
    exit;
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Усыновить <?= $animal['name'] ?></title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="header"><h1>Усыновить <span><?= $animal['name'] ?></span></h1></div>
<div style="max-width:500px; margin:40px auto; background:white; padding:40px; border-radius:20px;">
    <form method="POST">
        <input type="text" name="name" placeholder="Ваше имя" required style="width:100%; padding:10px; margin-bottom:15px;">
        <input type="text" name="phone" placeholder="Телефон" required style="width:100%; padding:10px; margin-bottom:15px;">
        <input type="submit" value="Отправить заявку" style="width:100%; background:#2e7d32; color:white; padding:12px; border:none; cursor:pointer;">
    </form>
    <div style="text-align:center; margin-top:20px;">
        <a href="moreDetails.php?id=<?= $id ?>" class="btn">Назад</a>
    </div>
</div>
<div class="footer"><p><a href="foundation.php">На главную</a></p></div>
</body>
</html>