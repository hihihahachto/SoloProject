-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 15 2026 г., 12:02
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
-- Структура таблицы `adoptions`
--

CREATE TABLE `adoptions` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `volunteer_id` int(11) NOT NULL,
  `adopter_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adopter_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adopter_address` text COLLATE utf8mb4_unicode_ci,
  `adoption_date` date NOT NULL,
  `contract_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_visit_done` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `adoptions`
--

INSERT INTO `adoptions` (`id`, `animal_id`, `volunteer_id`, `adopter_name`, `adopter_phone`, `adopter_address`, `adoption_date`, `contract_file`, `home_visit_done`) VALUES
(1, 1, 1, 'Мария Иванова', '+7(999)987-65-43', NULL, '2025-03-20', NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `species` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `breed` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `age_months` int(11) DEFAULT NULL,
  `color` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arrival_date` date NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'waiting',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `animals`
--

INSERT INTO `animals` (`id`, `name`, `species`, `breed`, `gender`, `age_months`, `color`, `arrival_date`, `status`, `description`, `created_at`) VALUES
(1, 'Барсик', 'cat', 'дворняга', 'male', 14, 'рыжий', '2025-01-10', 'waiting', NULL, '2026-04-15 05:05:14'),
(2, 'Шарик', 'dog', 'лабрадор', 'male', 30, 'чёрный', '2025-02-01', 'treatment', NULL, '2026-04-15 05:05:14'),
(3, 'Мурка', 'cat', 'британец', 'female', 24, 'серая', '2025-03-15', 'waiting', NULL, '2026-04-15 05:05:14');

-- --------------------------------------------------------

--
-- Структура таблицы `daily_routine`
--

CREATE TABLE `daily_routine` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `volunteer_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `action_type` enum('fed','walked','cleaned','played') COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `daily_routine`
--

INSERT INTO `daily_routine` (`id`, `animal_id`, `volunteer_id`, `date`, `action_type`, `notes`) VALUES
(1, 2, 1, '2025-03-25', 'walked', '30 минут на поводке');

-- --------------------------------------------------------

--
-- Структура таблицы `treatments`
--

CREATE TABLE `treatments` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `treatment_date` date NOT NULL,
  `diagnosis` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `medicine` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT '0.00',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `performed_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `treatments`
--

INSERT INTO `treatments` (`id`, `animal_id`, `treatment_date`, `diagnosis`, `medicine`, `cost`, `notes`, `performed_by`) VALUES
(1, 2, '2025-03-01', 'блошиный дерматит', 'Адвокат', '1500.00', NULL, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `volunteers`
--

CREATE TABLE `volunteers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skills` set('walking','feeding','medical','cleaning','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `hours_per_week` int(11) DEFAULT '0',
  `joined_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `volunteers`
--

INSERT INTO `volunteers` (`id`, `full_name`, `phone`, `email`, `skills`, `hours_per_week`, `joined_date`, `is_active`) VALUES
(1, 'Анна Петрова', '+7(999)123-45-67', NULL, 'walking,feeding,cleaning', 10, '2025-01-01', 1),
(2, 'Игорь Смирнов', '+7(999)234-56-78', NULL, 'medical,admin', 5, '2025-02-10', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `adoptions`
--
ALTER TABLE `adoptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `animal_id` (`animal_id`),
  ADD KEY `volunteer_id` (`volunteer_id`);

--
-- Индексы таблицы `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `daily_routine`
--
ALTER TABLE `daily_routine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`),
  ADD KEY `volunteer_id` (`volunteer_id`);

--
-- Индексы таблицы `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`),
  ADD KEY `performed_by` (`performed_by`);

--
-- Индексы таблицы `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `adoptions`
--
ALTER TABLE `adoptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `daily_routine`
--
ALTER TABLE `daily_routine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `treatments`
--
ALTER TABLE `treatments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `adoptions`
--
ALTER TABLE `adoptions`
  ADD CONSTRAINT `adoptions_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`),
  ADD CONSTRAINT `adoptions_ibfk_2` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`);

--
-- Ограничения внешнего ключа таблицы `daily_routine`
--
ALTER TABLE `daily_routine`
  ADD CONSTRAINT `daily_routine_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`),
  ADD CONSTRAINT `daily_routine_ibfk_2` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`);

--
-- Ограничения внешнего ключа таблицы `treatments`
--
ALTER TABLE `treatments`
  ADD CONSTRAINT `treatments_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treatments_ibfk_2` FOREIGN KEY (`performed_by`) REFERENCES `volunteers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
