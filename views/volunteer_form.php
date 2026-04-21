<?php
require_once '../model/models.php';

if ($_POST) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $skill = $_POST['skill'];
    $photo_url = $_POST['photo_url'];

    $exists = checkVolunteerByPhone($pdo, $phone);

    if ($exists) {
        ?>
        <!doctype html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <title>Ошибка</title>
            <style>
                body { text-align: center; padding: 50px; }
                .error-box { max-width: 400px; margin: 0 auto; background: #ffe0e0; padding: 30px; border-radius: 20px; }
                .error-text { font-size: 24px; color: red; margin: 20px 0; }
                .back-link { background-color: #666; color: white; padding: 10px 20px; text-decoration: none; border-radius: 10px; display: inline-block; }
            </style>
        </head>
        <body>
        <div class="error-box">
            <div class="error-text">Ошибка!</div>
            <p>Волонтёр с телефоном <?= htmlspecialchars($phone) ?> уже зарегистрирован.</p>
            <a href="volunteers.php" class="back-link">Вернуться</a>
        </div>
        </body>
        </html>
        <?php
        exit;
    }

    addVolunteer($pdo, $name, $phone, $skill, $photo_url);

    ?>
    <!doctype html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Спасибо!</title>
        <style>
            body { text-align: center; padding: 50px; }
            .thankyou-box { max-width: 400px; margin: 0 auto; background: #f0f8ff; padding: 30px; border-radius: 20px; }
            .thankyou-text { font-size: 24px; color: green; margin: 20px 0; }
            .back-link { background-color: #666; color: white; padding: 10px 20px; text-decoration: none; border-radius: 10px; display: inline-block; }
        </style>
    </head>
    <body>
    <div class="thankyou-box">
        <div class="thankyou-text">Спасибо, <?= htmlspecialchars($name) ?>!</div>
        <p>Вы теперь в команде волонтёров!</p>
        <a href="volunteers.php" class="back-link">Вернуться</a>
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
    <title>Стать волонтёром</title>
    <style>
        body { text-align: center; padding: 50px; }
        input, select { display: block; margin: 10px auto; padding: 10px; width: 250px; border-radius: 10px; border: 1px solid #ccc; }
        input[type="submit"] { width: 250px; background-color: #28a745; color: white; border: none; cursor: pointer; }
        .back-link { background-color: #666; color: white; padding: 10px 20px; text-decoration: none; border-radius: 10px; display: inline-block; }
        form { max-width: 300px; margin: 0 auto; }
    </style>
</head>
<body>

<h1>🤝 Стать волонтёром</h1>

<form method="POST">
    <input type="text" name="name" placeholder="Ваше имя" required>
    <input type="text" name="phone" placeholder="Телефон" required>
    <select name="skill">
        <option value="">Выберите навык</option>
        <option value="feeding">Кормление</option>
        <option value="walking">Выгул</option>
        <option value="medical">Медицинская помощь</option>
        <option value="cleaning">Уборка</option>
    </select>
    <input type="text" name="photo_url" placeholder="Ссылка на фото">
    <input type="submit" value="Стать волонтёром">
</form>

<br>
<a href="volunteers.php" class="back-link">← Назад</a>

</body>
</html>