<?php
require_once '../model/models.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM animals WHERE id = ?");
$stmt->execute([$id]);
$animal = $stmt->fetch();

if ($_POST) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $exists = checkAdoption($pdo, $id);
    if (!$exists) {
        addAdoption($pdo);
    }

    echo "<div style='text-align:center; padding:50px;'>
            <div style='background:#e8f5e9; max-width:400px; margin:0 auto; padding:30px; border-radius:20px;'>
                <img src='https://tse3.mm.bing.net/th/id/OIP.fVEBMBTRydlJYElJ_FwflAHaEb?rs=1&pid=ImgDetMain&o=7&rm=3' style='width:150px; height:150px; object-fit:cover; border-radius:50%; display:block; margin:0 auto 20px;'>
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

<div class="header">
    <h1>Усыновить <span><?= $animal['name'] ?></span></h1>
</div>

<div style="max-width: 500px; margin: 40px auto; background: white; padding: 40px; border-radius: 20px;">
    <form method="POST">
        <div style="margin-bottom: 15px;">
            <label>Ваше имя:</label>
            <input type="text" name="name" required style="width:100%; padding:10px; border-radius:10px; border:1px solid #ccc;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Телефон:</label>
            <input type="text" name="phone" required style="width:100%; padding:10px; border-radius:10px; border:1px solid #ccc;">
        </div>

        <input type="submit" value="Отправить заявку" style="width:100%; background:#2e7d32; color:white; padding:12px; border:none; border-radius:30px; font-size:16px; cursor:pointer;">
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <a href="moreDetails.php?id=<?= $id ?>" class="btn" style="background:#6c757d;">← Назад</a>
    </div>
</div>

<div class="footer">
    <p><a href="foundation.php">На главную</a></p>
</div>

</body>
</html>