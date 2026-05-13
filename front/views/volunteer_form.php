<?php
require_once 'database.php';
require_once '../SoloProject/api/controller/VolunteerController.php';
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Стать волонтёром</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<div class="header"><h1>Стать <span>волонтёром</span></h1></div>
<div style="max-width:500px; margin:40px auto; background:white; padding:40px; border-radius:20px;">
    <form id="volunteerForm">
        <input type="text" name="name" id="name" placeholder="Ваше имя" required style="width:100%; padding:10px; margin-bottom:15px;">
        <input type="text" name="phone" id="phone" placeholder="Телефон" required style="width:100%; padding:10px; margin-bottom:15px;">
        <select name="skill" id="skill" style="width:100%; padding:10px; margin-bottom:15px;">
            <option value="feeding">Кормление</option>
            <option value="walking">Выгул</option>
            <option value="medical">Медицина</option>
            <option value="cleaning">Уборка</option>
        </select>
        <input type="text" name="photo_url" id="photo_url" placeholder="Ссылка на фото" style="width:100%; padding:10px; margin-bottom:15px;">
        <input type="submit" value="Стать волонтёром" style="width:100%; background:#2e7d32; color:white; padding:12px; border:none; cursor:pointer;">
    </form>
    <div style="text-align:center; margin-top:20px;">
        <a href="volunteers.php" class="btn">Назад</a>
    </div>
</div>
<div class="footer"><p><a href="foundation.php">На главную</a></p></div>

<script src="api.js"></script>
<script>
    document.getElementById('volunteerForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = {
            full_name: document.getElementById('name').value,
            phone: document.getElementById('phone').value,
            skill: document.getElementById('skill').value,
            photo_url: document.getElementById('photo_url').value
        };

        try {
            const result = await VolunteersAPI.create(formData);

            if (result.status === true || result.success === true) {
                alert('Спасибо! Вы теперь волонтёр!');
                window.location.href = 'volunteers.php';
            } else {
                alert('Ошибка: ' + (result.message || result.error || 'Что-то пошло не так'));
            }
        } catch (error) {
            alert('Ошибка: ' + error.message);
        }
    });
</script>
</body>
</html>