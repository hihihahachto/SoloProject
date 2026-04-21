<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Приют</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .description-text {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 40px;
            font-size: 1.1rem;
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .card-img-top {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        .btn-custom {
            background-color: #666;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 10px;
            display: inline-block;
        }
        .btn-custom:hover {
            background-color: #444;
        }
    </style>
</head>
<body>
<h1 class="text-center mt-3">Вторая жизнь</h1>

<div class="container">
    <p class="description-text">
        Каждый, кто приходит к нам, получает второй шанс.<br>
        Мы — приют «Вторая жизнь». Сюда попадают те, кого когда-то забыли, предали или потеряли.
        Но здесь их не судят. Здесь их лечат, кормят, согревают и снова учат верить людям.<br><br>
        Наши двери открыты для тех, кто ищет верного друга. И для тех, кто готов стать для него целым миром.<br>
        <strong>Забери домой не просто питомца — забери судьбу, которую ты можешь сделать счастливой.</strong>
    </p>
</div>

<div class="container px-4 text-center">
    <div class="row gx-5 justify-content-center">
        <div class="col-md-auto mb-4">
            <div class="card" style="width: 18rem;">
                <img src="https://www.myplanet-ua.com/wp-content/uploads/2016/02/20141108121240.jpg"
                     class="card-img-top"
                     alt="Собака в приюте">
                <div class="card-body">
                    <h5 class="card-title">Наши животные</h5>
                    <p class="card-text">Посмотрите на наших красавчиков. Они ждут своего человека.</p>
                    <a href="animals.php" class="btn-custom">Смотреть всех →</a>
                </div>
            </div>
        </div>

        <div class="col-md-auto mb-4">
            <div class="card" style="width: 18rem;">
                <img src="https://tse1.mm.bing.net/th/id/OIP.6JMDeszCCvo3Ks5lj0ictgHaJ4?rs=1&pid=ImgDetMain&o=7&rm=3.jpg"
                     class="card-img-top"
                     alt="Кошка в приюте">
                <div class="card-body">
                    <h5 class="card-title">Стать волонтёром</h5>
                    <p class="card-text">Помогите нам заботиться о животных.</p>
                    <a href="volunteers.php" class="btn-custom">Подробнее →</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>