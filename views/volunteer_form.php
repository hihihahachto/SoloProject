<?php
require_once '../model/database.php';
require_once '../controller/VolunteerController.php';

if ($_POST) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $skill = $_POST['skill'];
    $photo_url = $_POST['photo_url'];

    $exists = checkVolunteerByPhone($pdo, $phone);

    if ($exists) {
        echo "<div style='text-align:center; padding:50px;'><h2 style='color:red;'>Ошибка! Волонтёр с телефоном $phone уже зарегистрирован.</h2><a href='volunteers.php' class='btn'>Вернуться</a></div>";
        exit;
    }

    $sql = "INSERT INTO volunteers (full_name, phone, skill, photo_url) VALUES (:full_name, :phone, :skill, :photo_url)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
            ':full_name' => $name,
            ':phone' => $phone,
            ':skill' => $skill,
            ':photo_url' => $photo_url
    ]);

    addNotification($pdo, "Новый волонтёр: $name, телефон: $phone", 'volunteer');

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
<div class="header"><h1>Стать <span>волонтёром</span></h1></div>
<div style="max-width:500px; margin:40px auto; background:white; padding:40px; border-radius:20px;">
    <form method="POST">
        <input type="text" name="name" placeholder="Ваше имя" required style="width:100%; padding:10px; margin-bottom:15px;">
        <input type="text" name="phone" placeholder="Телефон" required style="width:100%; padding:10px; margin-bottom:15px;">
        <select name="skill" style="width:100%; padding:10px; margin-bottom:15px;">
            <option value="feeding">Кормление</option>
            <option value="walking">Выгул</option>
            <option value="medical">Медицина</option>
            <option value="cleaning">Уборка</option>
        </select>
        <input type="text" name="photo_url" placeholder="Ссылка на фото" style="width:100%; padding:10px; margin-bottom:15px;">
        <input type="submit" value="Стать волонтёром" style="width:100%; background:#2e7d32; color:white; padding:12px; border:none; cursor:pointer;">
    </form>
    <div style="text-align:center; margin-top:20px;">
        <a href="volunteers.php" class="btn">Назад</a>
    </div>
</div>
<div class="footer"><p><a href="foundation.php">На главную</a></p></div>
</body>
</html>