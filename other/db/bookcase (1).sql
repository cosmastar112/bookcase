-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 05 2020 г., 21:32
-- Версия сервера: 5.6.41
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bookcase`
--

-- --------------------------------------------------------

--
-- Структура таблицы `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `author`
--

INSERT INTO `author` (`id`, `name`) VALUES
(28, 'Александр Дюма'),
(29, 'Гарриет Бичер-Стоу'),
(30, 'Эрнест Хемингуэй'),
(31, 'Вильгельм Буш'),
(32, 'Даниель Дефо'),
(33, 'Джером Клапка Джером'),
(34, 'Шевелов Виктор Макарович'),
(35, 'Герман Гессе'),
(36, 'Айзек Азимов'),
(37, 'Астафьев Виктор Петрович'),
(38, 'Артур Конан Дойл');

-- --------------------------------------------------------

--
-- Структура таблицы `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `title` varchar(120) NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `book`
--

INSERT INTO `book` (`id`, `title`, `author_id`) VALUES
(11, 'Хижина дяди Тома', 29),
(12, 'Граф Монте-Кристо', 28),
(13, 'Старик и море', 30),
(14, 'Иисус - наша судьба', 31),
(15, 'Робинзон Крузо', 32),
(16, 'Трое в лодке, не считая собаки', 33),
(17, 'Tе, кого мы любим, – живут', 34),
(18, 'Игра в бисер', 35),
(19, 'Конец Вечности', 36),
(20, 'Прокляты и убиты', 37),
(21, 'Этюд в багровых тонах', 38);

-- --------------------------------------------------------

--
-- Структура таблицы `log_actions`
--

CREATE TABLE `log_actions` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `section` varchar(50) NOT NULL,
  `action` int(11) NOT NULL COMMENT '1 - create, 2- update, 3 - delete',
  `model_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `log_actions`
--

INSERT INTO `log_actions` (`id`, `user`, `date`, `section`, `action`, `model_id`) VALUES
(61, 0, '2020-01-05 20:50:17', 'Author', 1, 28),
(62, 0, '2020-01-05 20:50:43', 'Author', 1, 29),
(63, 0, '2020-01-05 20:51:18', 'Author', 1, 30),
(64, 0, '2020-01-05 20:52:06', 'Author', 1, 31),
(65, 0, '2020-01-05 20:52:39', 'Author', 1, 32),
(66, 0, '2020-01-05 20:53:16', 'Author', 1, 33),
(67, 0, '2020-01-05 20:58:00', 'Author', 1, 34),
(68, 0, '2020-01-05 20:58:27', 'Author', 1, 35),
(69, 0, '2020-01-05 20:58:55', 'Author', 1, 36),
(70, 0, '2020-01-05 21:00:29', 'Book', 1, 11),
(71, 0, '2020-01-05 21:01:12', 'Book', 1, 12),
(72, 0, '2020-01-05 21:01:36', 'Book', 1, 13),
(73, 0, '2020-01-05 21:02:07', 'Book', 1, 14),
(74, 0, '2020-01-05 21:02:42', 'Book', 1, 15),
(75, 0, '2020-01-05 21:03:11', 'Book', 1, 16),
(76, 0, '2020-01-05 21:04:02', 'Book', 1, 17),
(77, 0, '2020-01-05 21:04:31', 'Book', 1, 18),
(78, 0, '2020-01-05 21:05:13', 'Book', 1, 19),
(79, 0, '2020-01-05 21:06:45', 'Author', 1, 37),
(80, 0, '2020-01-05 21:08:46', 'Book', 1, 20),
(81, 0, '2020-01-05 21:09:08', 'Author', 1, 38),
(82, 0, '2020-01-05 21:09:28', 'Book', 1, 21),
(83, 0, '2020-01-05 21:12:28', 'Register', 1, 9),
(84, 0, '2020-01-05 21:14:19', 'Register', 1, 10),
(85, 0, '2020-01-05 21:15:12', 'Register', 1, 11),
(86, 0, '2020-01-05 21:16:11', 'Register', 1, 12),
(87, 0, '2020-01-05 21:16:51', 'Register', 1, 13),
(88, 0, '2020-01-05 21:27:09', 'Register', 1, 14),
(89, 0, '2020-01-05 21:28:12', 'Register', 1, 15),
(90, 0, '2020-01-05 21:28:58', 'Register', 1, 16),
(91, 0, '2020-01-05 21:29:49', 'Register', 1, 17),
(92, 0, '2020-01-05 21:30:51', 'Register', 1, 18),
(93, 0, '2020-01-05 21:31:50', 'Register', 1, 19);

-- --------------------------------------------------------

--
-- Структура таблицы `log_values`
--

CREATE TABLE `log_values` (
  `id` int(11) NOT NULL,
  `id_log_action` int(11) NOT NULL,
  `field_name` varchar(25) NOT NULL,
  `old_value` varchar(255) DEFAULT NULL,
  `new_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `log_values`
--

INSERT INTO `log_values` (`id`, `id_log_action`, `field_name`, `old_value`, `new_value`) VALUES
(62, 61, 'name', NULL, 'Александр Дюма'),
(63, 61, 'id', NULL, '28'),
(64, 62, 'name', NULL, 'Гарриет Бичер-Стоу'),
(65, 62, 'id', NULL, '29'),
(66, 63, 'name', NULL, 'Эрнест Хемингуэй'),
(67, 63, 'id', NULL, '30'),
(68, 64, 'name', NULL, 'Вильгельм Буш'),
(69, 64, 'id', NULL, '31'),
(70, 65, 'name', NULL, 'Даниель Дефо'),
(71, 65, 'id', NULL, '32'),
(72, 66, 'name', NULL, 'Джером Клапка Джером'),
(73, 66, 'id', NULL, '33'),
(74, 67, 'name', NULL, 'Шевелов Виктор Макарович'),
(75, 67, 'id', NULL, '34'),
(76, 68, 'name', NULL, 'Герман Гессе'),
(77, 68, 'id', NULL, '35'),
(78, 69, 'name', NULL, 'Айзек Азимов'),
(79, 69, 'id', NULL, '36'),
(80, 70, 'title', NULL, 'Хижина дяди Тома'),
(81, 70, 'author_id', NULL, '29'),
(82, 70, 'id', NULL, '11'),
(83, 71, 'title', NULL, 'Граф Монте-Кристо'),
(84, 71, 'author_id', NULL, '28'),
(85, 71, 'id', NULL, '12'),
(86, 72, 'title', NULL, 'Старик и море'),
(87, 72, 'author_id', NULL, '30'),
(88, 72, 'id', NULL, '13'),
(89, 73, 'title', NULL, 'Иисус - наша судьба'),
(90, 73, 'author_id', NULL, '31'),
(91, 73, 'id', NULL, '14'),
(92, 74, 'title', NULL, 'Робинзон Крузо'),
(93, 74, 'author_id', NULL, '32'),
(94, 74, 'id', NULL, '15'),
(95, 75, 'title', NULL, 'Трое в лодке, не считая собаки'),
(96, 75, 'author_id', NULL, '33'),
(97, 75, 'id', NULL, '16'),
(98, 76, 'title', NULL, 'Tе, кого мы любим, – живут'),
(99, 76, 'author_id', NULL, '34'),
(100, 76, 'id', NULL, '17'),
(101, 77, 'title', NULL, 'Игра в бисер'),
(102, 77, 'author_id', NULL, '35'),
(103, 77, 'id', NULL, '18'),
(104, 78, 'title', NULL, 'Конец Вечности'),
(105, 78, 'author_id', NULL, '36'),
(106, 78, 'id', NULL, '19'),
(107, 79, 'name', NULL, 'Астафьев Виктор Петрович'),
(108, 79, 'id', NULL, '37'),
(109, 80, 'title', NULL, 'Прокляты и убиты'),
(110, 80, 'author_id', NULL, '37'),
(111, 80, 'id', NULL, '20'),
(112, 81, 'name', NULL, 'Артур Конан Дойл'),
(113, 81, 'id', NULL, '38'),
(114, 82, 'title', NULL, 'Этюд в багровых тонах'),
(115, 82, 'author_id', NULL, '38'),
(116, 82, 'id', NULL, '21'),
(117, 83, 'book_id', NULL, '11'),
(118, 83, 'date_start', NULL, '2014-05-10'),
(119, 83, 'date_end', NULL, '2014-05-16'),
(120, 83, 'id', NULL, '9'),
(121, 84, 'book_id', NULL, '12'),
(122, 84, 'date_start', NULL, '2014-05-20'),
(123, 84, 'date_end', NULL, '2014-06-14'),
(124, 84, 'id', NULL, '10'),
(125, 85, 'book_id', NULL, '13'),
(126, 85, 'date_start', NULL, '2014-06-24'),
(127, 85, 'date_end', NULL, '2014-06-25'),
(128, 85, 'id', NULL, '11'),
(129, 86, 'book_id', NULL, '14'),
(130, 86, 'date_start', NULL, '2014-07-02'),
(131, 86, 'date_end', NULL, '2014-07-13'),
(132, 86, 'id', NULL, '12'),
(133, 87, 'book_id', NULL, '15'),
(134, 87, 'date_start', NULL, '2014-07-16'),
(135, 87, 'date_end', NULL, '2014-07-18'),
(136, 87, 'id', NULL, '13'),
(137, 88, 'book_id', NULL, '16'),
(138, 88, 'date_start', NULL, '2014-10-01'),
(139, 88, 'date_end', NULL, '2014-10-04'),
(140, 88, 'id', NULL, '14'),
(141, 89, 'book_id', NULL, '17'),
(142, 89, 'date_start', NULL, '2014-10-06'),
(143, 89, 'date_end', NULL, '2014-10-13'),
(144, 89, 'id', NULL, '15'),
(145, 90, 'book_id', NULL, '18'),
(146, 90, 'date_start', NULL, '2014-10-18'),
(147, 90, 'date_end', NULL, '2014-10-28'),
(148, 90, 'id', NULL, '16'),
(149, 91, 'book_id', NULL, '19'),
(150, 91, 'date_start', NULL, '2014-11-01'),
(151, 91, 'date_end', NULL, '2014-11-02'),
(152, 91, 'id', NULL, '17'),
(153, 92, 'book_id', NULL, '20'),
(154, 92, 'date_start', NULL, '2014-11-15'),
(155, 92, 'date_end', NULL, '2014-12-17'),
(156, 92, 'id', NULL, '18'),
(157, 93, 'book_id', NULL, '21'),
(158, 93, 'date_start', NULL, '2014-12-28'),
(159, 93, 'date_end', NULL, '2014-12-29'),
(160, 93, 'id', NULL, '19');

-- --------------------------------------------------------

--
-- Структура таблицы `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `register`
--

INSERT INTO `register` (`id`, `book_id`, `date_start`, `date_end`) VALUES
(9, 11, '2014-05-10', '2014-05-16'),
(10, 12, '2014-05-20', '2014-06-14'),
(11, 13, '2014-06-24', '2014-06-25'),
(12, 14, '2014-07-02', '2014-07-13'),
(13, 15, '2014-07-16', '2014-07-18'),
(14, 16, '2014-10-01', '2014-10-04'),
(15, 17, '2014-10-06', '2014-10-13'),
(16, 18, '2014-10-18', '2014-10-28'),
(17, 19, '2014-11-01', '2014-11-02'),
(18, 20, '2014-11-15', '2014-12-17'),
(19, 21, '2014-12-28', '2014-12-29');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Индексы таблицы `log_actions`
--
ALTER TABLE `log_actions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `log_values`
--
ALTER TABLE `log_values`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT для таблицы `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `log_actions`
--
ALTER TABLE `log_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT для таблицы `log_values`
--
ALTER TABLE `log_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT для таблицы `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`);

--
-- Ограничения внешнего ключа таблицы `register`
--
ALTER TABLE `register`
  ADD CONSTRAINT `register_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
