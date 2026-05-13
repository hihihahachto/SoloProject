<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Приют "Вторая жизнь"</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>

<div class="header">
    <h1>Вторая <span>жизнь</span></h1>
    <p>Дом, где каждое животное получает шанс стать счастливым</p>
</div>

<div class="description">
    <p>
        Каждый, кто приходит к нам, получает второй шанс.<br>
        Мы — приют «Вторая жизнь». Сюда попадают те, кого когда-то забыли, предали или потеряли.
        Но здесь их не судят. Здесь их лечат, кормят, согревают и снова учат верить людям.
    </p>
    <p style="margin-top: 15px;">
        Наши двери открыты для тех, кто ищет верного друга. И для тех, кто готов стать для него целым миром.<br>
        <strong>Забери домой не просто питомца — забери судьбу, которую ты можешь сделать счастливой.</strong>
    </p>
</div>

<div class="cards">
    <div class="card">
        <img src="https://avatars.mds.yandex.net/i?id=de1f7889c513309c1ddc4304bbe2f664_l-4902831-images-thumbs&n=13.jpg" alt="Собака">
        <h3>Наши животные</h3>
        <p>Посмотрите на наших красавчиков. Они ждут своего человека.</p>
        <a href="animals.php" class="btn">Смотреть всех →</a>
    </div>

    <div class="card">
        <img src="https://tse1.mm.bing.net/th/id/OIP.6JMDeszCCvo3Ks5lj0ictgHaJ4?rs=1&pid=ImgDetMain&o=7&rm=3.jpg" alt="Кошка">
        <h3>Стать волонтёром</h3>
        <p>Помогите нам заботиться о животных. Ваша помощь может спасти жизнь!</p>
        <a href="volunteers.php" class="btn">Подробнее →</a>
    </div>
</div>

<div class="footer">
    <p>🐾 Приют «Вторая жизнь» — дарим надежду тем, кто в ней нуждается</p>
    <p><a href="admin_login.php">Админ-панель</a></p>
</div>
<script src="api.js"></script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        AnimalsAPI.getAll().then(animals => {
            console.log('В приюте животных:', animals.length);
        }).catch(err => console.error('Ошибка API:', err));
    });
</script>
</body>
</html>
