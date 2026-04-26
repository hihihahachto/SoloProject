<?php
require_once '../model/models.php';

if ($_POST) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $skill = $_POST['skill'];
    $photo_url = $_POST['photo_url'];

    $exists = checkVolunteerByPhone($pdo, $phone);
    if ($exists) {
        echo "<div style='text-align:center; padding:50px;'>
                <h2 style='color:red;'>Ошибка!</h2>
                <p>Волонтёр с телефоном $phone уже зарегистрирован.</p>
                <a href='volunteers.php' class='btn'>Вернуться</a>
              </div>";
        exit;
    }

    addVolunteer($pdo);
    echo "<div style='text-align:center; padding:50px;'>
            <div style='background:#e8f5e9; max-width:400px; margin:0 auto; padding:30px; border-radius:20px;'>
                <h2 style='color:green;'>Спасибо, $name!</h2>
                <p>Вы теперь в команде волонтёров!</p>
                <a href='volunteers.php' class='btn'>Вернуться</a>
            </div>
          </div>";
    exit;
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Стать волонтёром</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>

<div class="header">
    <h1>Стать <span>волонтёром</span></h1>
    <p>Заполните форму, чтобы присоединиться к нашей команде</p>
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

        <div style="margin-bottom: 15px;">
            <label>Навык:</label>
            <select name="skill" style="width:100%; padding:10px; border-radius:10px; border:1px solid #ccc;">
                <option value="feeding">Кормление</option>
                <option value="walking">Выгул</option>
                <option value="medical">Медицина</option>
                <option value="cleaning">Уборка</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Ссылка на фото:</label>
            <input type="text" name="photo_url" style="width:100%; padding:10px; border-radius:10px; border:1px solid #ccc;">
        </div>

        <input type="submit" value="Стать волонтёром" style="width:100%; background:#2e7d32; color:white; padding:12px; border:none; border-radius:30px; font-size:16px; cursor:pointer;">
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <a href="volunteers.php" class="btn" style="background:#6c757d;">← Назад</a>
    </div>
</div>

<div class="footer">
    <p><a href="foundation.php">На главную</a></p>
</div>

</body>
</html>