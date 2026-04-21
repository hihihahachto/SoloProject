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
        addAdoption($pdo, $id, $name, $phone);
    }

    ?>
    <!doctype html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Спасибо!</title>
        <style>
            body { text-align: center; padding: 50px; }
            .thankyou-box { max-width: 400px; margin: 0 auto; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
            .thankyou-photo { width: 200px; height: 200px; object-fit: cover; display: block; margin: 0 auto 20px; }
            .thankyou-text { font-size: 24px; color: green; margin: 20px 0; }
            .back-link { background-color: #666; color: white; padding: 10px 20px; text-decoration: none; border-radius: 10px; display: inline-block; }
        </style>
    </head>
    <body>
    <div class="thankyou-box">
        <img src="https://tse3.mm.bing.net/th/id/OIP.fVEBMBTRydlJYElJ_FwflAHaEb?rs=1&pid=ImgDetMain&o=7&rm=3" class="thankyou-photo">
        <div class="thankyou-text">Спасибо, <?= htmlspecialchars($name) ?>!</div>
        <p>Ваша заявка на усыновление <?= $animal['name'] ?> отправлена.</p>
        <a href="animals.php" class="back-link">Вернуться</a>
    </div>
    </body>
    </html>
    <?php
    exit;
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Усыновить <?= $animal['name'] ?></title>
    <style>
        body { text-align: center; padding: 50px; }
        input { display: block; margin: 10px auto; padding: 10px; width: 250px; border-radius: 10px; border: 1px solid #ccc; }
        input[type="submit"] { width: 250px; background-color: #28a745; color: white; border: none; cursor: pointer; }
        .back-link { background-color: #666; color: white; padding: 10px 20px; text-decoration: none; border-radius: 10px; display: inline-block; }
    </style>
</head>
<body>

<h1>Усыновить <?= $animal['name'] ?></h1>

<form method="POST">
    <input type="text" name="name" placeholder="Ваше имя" required>
    <input type="text" name="phone" placeholder="Телефон" required>
    <input type="submit" value="Отправить">
</form>

<br>
<a href="moreDetails.php?id=<?= $id ?>" class="back-link">← Назад</a>

</body>
</html>