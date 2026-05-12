<?php
require_once '../model/database.php';
require_once '../model/VolunteerController.php';

$volunteers = getAllVolunteers($pdo);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Волонтёры</title>
    <link rel="stylesheet" href="../css/main.css">
    <style>
        .volunteers-page {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
        }
        .volunteers-list {
            flex: 2;
            min-width: 280px;
        }
        .info-sidebar {
            flex: 1;
            min-width: 280px;
        }
        .info-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .info-card h3 {
            color: #5a8a5a;
            margin-bottom: 15px;
            border-left: 4px solid #7eb07e;
            padding-left: 12px;
        }
        .info-card ul {
            list-style: none;
            padding: 0;
        }
        .info-card li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;}
        .
            gap: 10px;
        need-badge {
            background: #e0ecd0;
            color: #4a6e4a;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #5a8a5a;
        }
        .quote {
            font-style: italic;
            color: #555;
            line-height: 1.6;
        }
        @media (max-width: 900px) {
            .volunteers-page {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Наши <span>волонтёры</span></h1>
    <p>Люди с большим сердцем, которые делают мир добрее</p>
</div>

<div class="volunteers-page">

    <!-- Левая колонка: список волонтёров -->
    <div class="volunteers-list">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px;">
            <?php foreach ($volunteers as $vol): ?>
                <div class="card" style="margin:0;">
                    <?php if ($vol['photo_url']): ?>
                        <img src="<?= $vol['photo_url'] ?>" class="card-img-top" alt="<?= $vol['full_name'] ?>" style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <img src="https://images.pexels.com/photos/771742/pexels-photo-771742.jpeg?auto=compress&cs=tinysrgb&w=300" class="card-img-top" alt="Волонтёр" style="height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h3 style="margin: 0 0 5px 0;"><?= htmlspecialchars($vol['full_name']) ?></h3>
                        <p style="color: #666; margin-bottom: 10px;">📞 <?= $vol['phone'] ?></p>
                            <?php
                            $skill_rus = '';
                            if ($vol['skill'] == 'feeding') $skill_rus = 'Кормление';
                            if ($vol['skill'] == 'walking') $skill_rus = 'Выгул';
                            if ($vol['skill'] == 'medical') $skill_rus = 'Медицина';
                            if ($vol['skill'] == 'cleaning') $skill_rus = 'Уборка';
                            ?>
                            <span class="need-badge"><?= $skill_rus ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($volunteers)): ?>
            <div style="text-align: center; padding: 50px; background: white; border-radius: 20px;">
                <p>Пока нет волонтёров. Будьте первым!</p>
            </div>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 30px;">
            <a href="volunteer_form.php" class="btn">🤝 Присоединиться к волонтёрам</a>
        </div>
    </div>

    <!-- Правая колонка: информация -->
    <div class="info-sidebar">
        <div class="info-card">
            <h3>🌟 Почему волонтёры важны?</h3>
            <p>Без волонтёров приют не сможет существовать. Именно вы дарите животным:</p>
            <ul>
                <li>🍲 Еду и воду</li>
                <li>🚶 Прогулки и заботу</li>
                <li>💊 Лечение и ласку</li>
                <li>🏠 Шанс на новый дом</li>
            </ul>
        </div>

        <div class="info-card">
            <h3>🙋 Кого мы ищем?</h3>
            <ul>
                <li><span class="need-badge">Кормление</span> — помощь с кормлением животных</li>
                <li><span class="need-badge">Выгул</span> — прогулки с собаками</li>
                <li><span class="need-badge">Медицина</span> — помощь в лечении</li>
                <li><span class="need-badge">Уборка</span> — поддержание чистоты</li>
                <li><span class="need-badge">Администрирование</span> — помощь с соцсетями и документами</li>
            </ul>
        </div>

        <div class="info-card">
            <h3>📊 Наша статистика</h3>
            <p><span class="stat-number"><?= count($volunteers) ?></span> <br>активных волонтёров</p>
            <p><span class="stat-number">150+</span> <br>животных спасено за год</p>
            <p><span class="stat-number">24/7</span> <br>забота о питомцах</p>
        </div>

        <div class="info-card">
            <h3>💚 Что вы получите?</h3>
            <ul>
                <li>✓ Благодарность животных и команды</li>
                <li>✓ Новые знакомства и опыт</li>
                <li>✓ Сертификат волонтёра</li>
                <li>✓ Тёплые письма от питомцев</li>
            </ul>
        </div>

        <div class="info-card">
            <div class="quote">
                "Однажды я пришла покормить кошек, а осталась навсегда. Это лучшее решение в моей жизни!"
                <br><br>
                <strong>— Анна, волонтёр с 3-летним стажем</strong>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <p><a href="foundation.php">← На главную</a></p>
</div>

</body>
</html>