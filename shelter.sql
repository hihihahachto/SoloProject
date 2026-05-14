-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 14 2026 г., 18:59
-- Версия сервера: 5.7.39
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shelter`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `login` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `login`, `password`, `token`) VALUES
(1, 'admin', '2525', 'mySecretAdminToken123');

-- --------------------------------------------------------

--
-- Структура таблицы `adoptions`
--

CREATE TABLE `adoptions` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `adopter_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adopter_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adoption_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `adoptions`
--

INSERT INTO `adoptions` (`id`, `animal_id`, `adopter_name`, `adopter_phone`, `adoption_date`) VALUES
(13, 1, 'амам', '+2333233', '2026-04-21'),
(14, 2, 'Настикс', '+7(961)055-12-78', '2026-04-21'),
(15, 5, 'Мария ', '+7(999)122-45-65', '2026-04-21'),
(16, 8, 'Альмира Анимешн', '+7(999)129-45-65', '2026-05-09'),
(17, 6, 'шншпгог', '45654', '2026-05-09'),
(18, 7, 'пкку', 'к434242', '2026-05-10');

-- --------------------------------------------------------

--
-- Структура таблицы `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `species` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `breed` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'waiting',
  `photo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `animals`
--

INSERT INTO `animals` (`id`, `name`, `species`, `breed`, `age`, `status`, `photo_url`) VALUES
(1, 'Барсик', 'кот', 'дворняга', 13, 'adopted', 'https://koshka.top/uploads/posts/2021-12/1639492793_20-koshka-top-p-koshki-na-ulitse-20.jpg'),
(2, 'Шарик', 'собака', 'лабрадор', 30, 'adopted', 'https://petsi.net/images/dogphotos/labrador-retriever.jpg'),
(3, 'Мурка', 'кошка', 'британец', 24, 'adopted', 'https://tse3.mm.bing.net/th/id/OIP.rG6Phu5qhCMhiGlHglxOUAHaE8?rs=1&pid=ImgDetMain&o=7&rm=3'),
(4, 'Рыжик', 'кот', 'персидский', 8, 'adopted', 'https://tse4.mm.bing.net/th/id/OIP.LKOuCiGVPhH-defBOvvbnAHaE1?rs=1&pid=ImgDetMain&o=7&rm=3'),
(5, 'Джек', 'собака', 'овчарка', 18, 'adopted', 'https://th.bing.com/th/id/R.db06cd489938124b16bf8a34dcf07d2d?rik=eoBOo9PwqWzmRQ&pid=ImgRaw&r=0'),
(6, 'Муся', 'кошка', 'манчкин', 10, 'waiting', 'https://img.ixbt.site/live/images/original/08/11/28/2024/03/06/0b30733b84.jpg'),
(7, 'Жужа', 'собака', 'той терьер', 4, 'adopted', 'https://i.oneme.ru/i?r=BTE2sh_eZW7g8kugOdIm2NotP0DFhne3JxYMkr8WndVc2YlUssIpqrbqAjkr23oeJZA'),
(8, 'Бося', 'кошка', 'лиси попа', 18, 'adopted', 'https://i.oneme.ru/i?r=BTE2sh_eZW7g8kugOdIm2NoteD1b-TkvDM_WT3XEsGPhAIlUssIpqrbqAjkr23oeJZA');

-- --------------------------------------------------------

--
-- Структура таблицы `animal_details`
--

CREATE TABLE `animal_details` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `character_desc` text COLLATE utf8mb4_unicode_ci,
  `health_desc` text COLLATE utf8mb4_unicode_ci,
  `story` text COLLATE utf8mb4_unicode_ci,
  `text` text COLLATE utf8mb4_unicode_ci,
  `treatment_text` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `animal_details`
--

INSERT INTO `animal_details` (`id`, `animal_id`, `character_desc`, `health_desc`, `story`, `text`, `treatment_text`) VALUES
(1, 1, 'Ласковый и спокойный, любит спать на коленях', 'Здоров, привит', 'Найден на улице голодным', 'Барсика нашли в феврале возле мусорных баков. Он сидел в сломанной коробке, весь продрогший и голодный. Ему было около двух месяцев.\r\n\r\nКто-то выбросил его на улицу, как ненужную вещь. Волонтёр Анна заметила крошечный комочек шерсти, когда возвращалась с работы. Барсик не мяукал — у него не было сил.\r\n\r\nВ приюте его отогрели, накормили и вылечили. Оказалось, что у него был бронхит, но теперь он полностью здоров.\r\n\r\nСейчас Барсик — ласковый и игривый кот. Он любит спать на коленях и встречать людей у двери. Несмотря на всё, что пережил, он доверяет людям и очень ждёт своего человека.\r\n\r\nБарсику нужен дом и любящие руки. Он обещает стать самым преданным другом.\r\n\r\nЗабери Барсика домой. Он заслужил счастье. 🐾', 'Барсик поступил в приют с сильным бронхитом. Он был очень слабый и отказывался от еды.\r\n\r\n🏥 Как проходило лечение:\r\n- Первые 5 дней: антибиотики (Амоксициллин) 2 раза в день\r\n- Противовоспалительные препараты\r\n- Иммуномодуляторы для укрепления иммунитета\r\n- Теплые укутывания и покой\r\n\r\n💊 Что принимает сейчас:\r\n- Витаминный комплекс (1 месяц)\r\n- Пробиотики для восстановления кишечника\r\n\r\n🍗 В чем нуждается:\r\n- Качественное питание (влажный корм премиум-класса)\r\n- Теплое место без сквозняков\r\n- Забота и ласка для восстановления психологического состояния\r\n\r\nСейчас Барсик чувствует себя хорошо, но ему нужен дом, где о нем будут заботиться.'),
(2, 2, 'Активный и дружелюбный, любит играть с мячом', 'Нуждается в ежедневных прогулках', 'Хозяева уехали и оставили', 'Шарика отдали в приют, когда ему было полтора года. Прежние хозяева не рассчитали силы — лабрадор вырос большим, активным, ему нужно было много гулять и заниматься. А у них не было времени.\r\n\r\nШарик не стал плохим или злым. Он просто остался без выгула и начал скучать — грызть вещи, лаять от безделья. Хозяева решили, что не справляются, и привезли его к нам.\r\n\r\nВ приюте Шарик быстро показал свой характер — он обожает людей, виляет хвостом каждому, кто проходит мимо вольера. Больше всего на свете он любит мяч. Если кинуть ему игрушку, он принесёт её снова и снова, сколько захотите.\r\n\r\nСейчас Шарику 2,5 года. Это молодой, здоровый пёс в расцвете сил. Ему не нужны лекарства и особый уход. Ему нужен человек, который будет гулять с ним каждый день.\r\n\r\nШарик обещает стать самым верным другом, который всегда рад вас видеть.', 'Шарик полностью здоров. Единственное, что ему нужно — ежедневные активные прогулки.\r\n\r\nЧто нужно Шарику:\r\n\r\nПрогулки 2 раза в день минимум по часу\r\n\r\nВозможность побегать без поводка (в парке или на огороженной площадке)\r\n\r\nИгрушки особенно мячики\r\n\r\nВнимание и общение — лабрадоры плохо переносят одиночество\r\n\r\nЧто он умеет:\r\n\r\nПриносить мяч (апорт)\r\n\r\nЛюбит всех людей и других собак\r\n\r\nСпокойно относится к детям'),
(3, 3, 'Скромная и тихая, любит одиночество', 'Хроническая проблема с почками', 'Забрали из квартиры с 10 кошками', 'Мурку отдали в приют, когда ей было 8 месяцев. Прежние хозяева сказали, что она «слишком скромная и тихая». Им хотелось весёлую и игривую кошку, а Селин всё время пряталась под диван.\r\n\r\nВ приюте волонтёры заметили, что она много пьёт, худеет и иногда её рвёт. Ветеринар поставил диагноз — хроническая проблема с почками. Такое часто бывает у британцев, особенно если неправильно кормить.\r\n\r\nСейчас Мурка чувствует себя хорошо. Лекарства и диета помогают ей жить нормальной жизнью. Она всё такая же скромная и тихая — любит лежать в уголке и никого не трогать. Но если её погладить, тихонько мурлычет.\r\n\r\nМурка ищет человека, который примет её без игр и шума. Она обещает стать спокойным и благодарным другом.\r\n\r\n', 'Мурка поступила в приют с хронической болезнью почек (ХБП), стадия II–III.\r\n\r\nКак проходило лечение:\r\n\r\nПервые 2 недели: подкожные инъекции раствора Рингера (через день)\r\n\r\nПротиворвотные препараты (Церукал) — по необходимости\r\n\r\nСорбенты (Ипакитине) — для вывода токсинов\r\n\r\nЧто принимает сейчас:\r\n\r\nЛечебный корм Royal Canin Renal (только влажный)\r\n\r\nРеналокин — 2 раза в день\r\n\r\nСемаприт — 1 раз в день\r\n\r\nПоддерживающие инъекции — 1 раз в неделю\r\n\r\nВ чем нуждается:\r\n\r\nСпециальный лечебный корм пожизненно\r\n\r\nЧистая вода в доступе 24/7\r\n\r\nТишина и отсутствие стресса\r\n\r\nСпокойный человек, который не будет требовать от неё игр'),
(4, 4, 'Игривый и любопытный, не боится людей', 'Полностью здоров', 'Родился в приюте', 'Рыжика принесли в приют чужие люди. Они нашли его в подъезде — маленького, пушистого, совершенно домашнего. Кто-то выставил его на лестничную клетку и закрыл дверь.\r\n\r\nЕму тогда было всего два месяца.\r\n\r\nВ приюте Рыжик не боялся волонтёров. Он сразу пошёл на руки, замурлыкал и начал играть с шнурками. Видно было, что его любили, а потом просто выбросили.\r\n\r\nСейчас Рыжику 8 месяцев. Это молодой, здоровый и очень красивый кот. Персидская шерсть требует ухода, но он к этому привык — спокойно сидит, когда его расчёсывают.\r\n\r\nРыжик не помнит обиды. Он всё такой же доверчивый, игривый и любопытный. Бежит к каждому, кто открывает дверь, любит залезать в пакеты и коробки, гоняет мячики и следит за мухами.\r\n\r\nЕму нужен дом, где его не предадут снова.', 'Рыжик полностью здоров.\r\n\r\nЧто нужно Рыжику:\r\n\r\nРегулярное вычёсывание (персидская шерсть склонна к колтунам)\r\n\r\nКачественное питание (премиум-класс)\r\n\r\nИгрушки и пространство для игр\r\n\r\nЛоток с высокими бортами (из-за пушистой «юбки»)\r\n\r\nОн хорошо переносит:\r\n\r\nДругих кошек и собак\r\n\r\nГостей и детей\r\n\r\nПоездки к ветеринару'),
(5, 5, 'Преданный и умный, слушается команд', 'Лечится от ушной инфекции', 'Отказник от заводчика', 'Джека нашли на стройке около года назад. Он сидел на куче песка и смотрел на рабочих — ждал, что кто-то его покормит. Был худой и напуганный, постоянно прижимал уши и тряс головой.\r\n\r\nВ приюте он быстро показал, что он не просто дворовая собака. Джек — чистокровная овчарка с отличными задатками. Он слушается команд, умный и очень хочет угодить человеку.\r\n\r\nСейчас ему полтора года. Он полностью здоров, если не считать ушной инфекции, которую мы сейчас лечим. Это временное.\r\n\r\nДжек преданный и серьёзный пёс. Он не будет прыгать на прохожих или носиться без цели. Он будет смотреть в глаза и ждать следующей команды. Такому псу нужен хозяин, который готов заниматься и давать ему работу.\r\n\r\nДжек не ищет диван. Он ищет друга и вожака.', 'Джек поступил в приют с запущенной ушной инфекцией (отит). Уши были грязные, красные, собака постоянно трясла головой и болезненно реагировала на прикосновения.\r\n\r\nКак проходит лечение:\r\n\r\nУшные капли с антибиотиком — 2 раза в день (курс 10-14 дней)\r\n\r\nОчистка ушей перед закапыванием\r\n\r\nПротивовоспалительные препараты (первые 5 дней)\r\n\r\nЧто останется после лечения:\r\n\r\nПериодическая чистка ушей (1 раз в неделю)\r\n\r\nОсмотр после купания, чтобы вода не застаивалась\r\n\r\nВ чем нуждается:\r\n\r\nЕжедневные прогулки и физическая нагрузка\r\n\r\nКоманды и занятия (овчаркам нужна работа)\r\n\r\nУход за ушами после выздоровления');

-- --------------------------------------------------------

--
-- Структура таблицы `medical_records`
--

CREATE TABLE `medical_records` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `record_date` date NOT NULL,
  `diagnosis` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medicine` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `medical_records`
--

INSERT INTO `medical_records` (`id`, `animal_id`, `record_date`, `diagnosis`, `medicine`) VALUES
(1, 1, '2025-01-15', 'Осмотр', 'Прививка от бешенства'),
(2, 2, '2025-02-01', 'Блохи', 'Капли Адвокат'),
(3, 3, '2025-02-10', 'Хроническая почечная недостаточность', 'Корм Renal'),
(4, 4, '2025-03-01', 'Осмотр', 'Прививка комплексная'),
(5, 5, '2025-03-10', 'Отит (воспаление уха)', 'Капли Отибиовин');

-- --------------------------------------------------------

--
-- Структура таблицы `volunteers`
--

CREATE TABLE `volunteers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skill` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `volunteers`
--

INSERT INTO `volunteers` (`id`, `full_name`, `phone`, `skill`, `photo_url`) VALUES
(1, 'Анна Петрова', '+7(999)123-45-67', 'feeding', 'https://media.istockphoto.com/id/1320191380/photo/teenage-girl-is-sitting-outside-hugging-her-australian-kelpie-black-and-brown-dog.jpg?s=170667a&w=0&k=20&c=vDJvz8Pr_VQh3NEt6q5QctwQBFoW6jHgbswkLS4VJ-s='),
(2, 'Игорь Смирнов', '+7(999)234-56-78', 'medical', 'https://tse1.mm.bing.net/th/id/OIP.eV5rJi4HAVTaS9GO-p7AkAHaE8?w=540&h=360&rs=1&pid=ImgDetMain&o=7&rm=3'),
(3, 'Ольга Иванова', '+7(999)345-67-89', 'walking', 'https://vzyat-pitomca.ru/uploads/s/1/z/8/1z8jyrtqycxd/img/autocrop/1811d1b1f66cc6e1747e95fda1a8880b.jpg'),
(4, 'Дмитрий Козлов', '+7(999)456-78-90', 'cleaning', 'https://tse1.mm.bing.net/th/id/OIP.h_ExIm2aw3MvLEHz5-DUuQHaHa?w=640&h=640&rs=1&pid=ImgDetMain&o=7&rm=3'),
(6, 'Каролина Михайловна', '+7(999)344-45-65', 'medical', 'https://cdnn11.img.sputnik.by/img/07e7/0c/13/1082165022_0:0:1280:960_1920x0_80_0_0_5da9c27e8e0ec1456c5700557e423b45.jpg.webp');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Индексы таблицы `adoptions`
--
ALTER TABLE `adoptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adoptions_ibfk_1` (`animal_id`);

--
-- Индексы таблицы `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `animal_details`
--
ALTER TABLE `animal_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `animal_id` (`animal_id`);

--
-- Индексы таблицы `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Индексы таблицы `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `adoptions`
--
ALTER TABLE `adoptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `animal_details`
--
ALTER TABLE `animal_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `adoptions`
--
ALTER TABLE `adoptions`
  ADD CONSTRAINT `adoptions_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`);

--
-- Ограничения внешнего ключа таблицы `animal_details`
--
ALTER TABLE `animal_details`
  ADD CONSTRAINT `animal_details_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
