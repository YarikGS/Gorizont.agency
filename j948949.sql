-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Хост: 10.0.0.160:3306
-- Время создания: Мар 10 2020 г., 02:25
-- Версия сервера: 10.1.43-MariaDB
-- Версия PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `j948949`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cases`
--

CREATE TABLE `cases` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `position` int(11) NOT NULL DEFAULT '1',
  `portfolio_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `cases`
--

INSERT INTO `cases` (`id`, `name`, `value`, `position`, `portfolio_id`) VALUES
(3, 'slider', '', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('091baa87f020e7cd0417f51a885120dfa8db630b', '213.230.92.173', 1583773682, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333737333530393b6c616e677c733a373a227275737369616e223b6c616e675f7072656669787c733a323a227275223b),
('02076c38c122fe31782a2ecab7f308510ea5ba69', '176.226.228.222', 1583773798, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333737333639353b6c616e677c733a373a227275737369616e223b6c616e675f7072656669787c733a323a227275223b),
('865f16b0cb0d555c7fcf6e6f0edc7f1225b5e5ad', '176.226.228.222', 1583774007, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333737333939343b6c616e677c733a373a227275737369616e223b6c616e675f7072656669787c733a323a227275223b),
('2496868450508e7ffd83b2bd51741e7b8b205749', '213.230.92.173', 1583774052, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333737343031373b6c616e677c733a373a227275737369616e223b6c616e675f7072656669787c733a323a227275223b),
('e151634734a37c8c4dea166aa69d69344fc4d3d2', '213.230.92.173', 1583774069, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333737343036393b6c616e677c733a373a227275737369616e223b6c616e675f7072656669787c733a323a227275223b),
('4188be0cfe4d9753ab6c7bdc1e6a9630812b7316', '213.230.92.173', 1583774071, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333737343037313b6c616e677c733a373a227275737369616e223b6c616e675f7072656669787c733a323a227275223b),
('5ecb15d58db3b07c1781bed0f65bedecfcb3f0b0', '176.226.228.222', 1583776218, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333737363231383b6c616e677c733a373a227275737369616e223b6c616e675f7072656669787c733a323a227275223b),
('47d4f8fb4f803fdf84139f5f7d6f4b5d17f4eb98', '176.226.228.222', 1583776218, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333737363231383b6c616e677c733a373a227275737369616e223b6c616e675f7072656669787c733a323a227275223b),
('5aa24887235fc528fe8c3d183364d2c642eda3ee', '188.163.83.146', 1583784732, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333738343733323b6c616e677c733a373a227275737369616e223b6c616e675f7072656669787c733a323a227275223b),
('0159f29b4c683fdff65df91abfa07c0601f704f2', '95.108.213.24', 1583794668, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333739343636373b6c616e677c733a373a227275737369616e223b6c616e675f7072656669787c733a323a227275223b),
('8bf798b137b7d52c3b2adbc6c455489e002452e0', '141.8.142.143', 1583794790, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333739343739303b6c616e677c733a373a227275737369616e223b6c616e675f7072656669787c733a323a227275223b),
('e211677b779736a6860b47cff4f99e78faf7f392', '52.50.65.100', 1583799082, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333739393038323b6c616e677c733a373a227275737369616e223b6c616e675f7072656669787c733a323a227275223b),
('eb64a089db17b0b395742f92748ccb65940922fa', '66.249.64.132', 1583803737, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333830333733373b6c616e677c733a373a227275737369616e223b6c616e675f7072656669787c733a323a227275223b);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Структура таблицы `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `main`
--

CREATE TABLE `main` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL DEFAULT '',
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `main_captions`
--

CREATE TABLE `main_captions` (
  `id` int(11) UNSIGNED NOT NULL,
  `value` text NOT NULL,
  `type` varchar(11) NOT NULL DEFAULT '0',
  `comments` varchar(80) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `main_captions`
--

INSERT INTO `main_captions` (`id`, `value`, `type`, `comments`) VALUES
(1, '', 'pdf_link', ''),
(2, 'Агентство нестандартных решений', 'title', ''),
(3, '«Горизонт завален» — официально означает непараллельность линии горизонта на фотографии горизонтали на мониторе, что является одной из самых «детских», глупых и дилетантских ошибок горе-фотографов.\r\n\r\nВпрочем, справедливости ради нужно заметить, что заваленный горизонт используется как приём для выразительного построения кадра в художественной фотографии (известен как «голландский угол»).', 'text', ''),
(4, '\r\nг.Челябинск, ул. Свободы, 2, 5Аs\r\n+79068622020\r\n+7 906 862 20 20\r\ninfo@gorizont.agency', 'contact', ''),
(5, '309', 'statistic_1', 'Реализованных промосъемок'),
(6, '20', 'statistic_2', 'Проведенных мероприятий'),
(7, '1000', 'statistic_3', 'Успешно проведенных проектов');

-- --------------------------------------------------------

--
-- Структура таблицы `main_sections`
--

CREATE TABLE `main_sections` (
  `id` int(11) UNSIGNED NOT NULL,
  `value` varchar(50) NOT NULL DEFAULT '',
  `parental_id` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `main_sections`
--

INSERT INTO `main_sections` (`id`, `value`, `parental_id`) VALUES
(1, 'SMM', 0),
(2, 'Web', 0),
(3, 'Фото/видео съемки', 0),
(4, 'Графический дизайн', 0),
(5, 'Нейминг и копирайтинг', 0),
(6, 'Контент-маркетинг', 0),
(7, 'Таргетированная реклама', 1),
(8, 'Email-маркетинг', 1),
(9, 'Контекстная реклама', 1),
(10, 'Работа с блогерами', 1),
(11, 'Контент-маркетинг', 1),
(12, 'Веб-разработка', 2),
(13, 'Разработка веб-сайтов', 2),
(14, 'Поддержка и развитие веб-сайтов', 2),
(15, 'Фотопродакшн', 3),
(16, 'Видеопродакшн', 3),
(17, 'Digital', 4),
(18, 'Полиграфия', 4),
(19, 'Типографские услуги', 4),
(20, 'VR', 4),
(21, 'Моушн-дизайн', 4),
(22, 'Разработка креативных концепций', 5),
(23, 'Написание продающих текстов', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) UNSIGNED NOT NULL,
  `header` varchar(40) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `img` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `portfolio`
--

INSERT INTO `portfolio` (`id`, `header`, `description`, `img`) VALUES
(1, 'Kinder Bueno White', 'Пример того, что иногда на отличную рекламу не нужно тратить миллионы и изобретать велосипед. Что делают агентства, когда им «в руки» попадает заказ на продвижение съедобной продукции? Начинают настраивать таргетированную рекламу, описывают на трех листах невероятное сочетание орехового пралине с шоколадной крошкой, используя шаблонные фото детей с эмоцией удовольствия на лице. Вас это трогает? Вот и мы решили, что лучший способ убедить потребителя в том, что это вкусно – накормить его. Мы выстроили стратегию размещения дегустационных площадок, проанализировав охват и проходимость в крупных моллах и торговых точках. Большая дегустация в ГМ «Лента» и СМ «Перекресток» в прайм-тайм принесла новому продукту более 2000 поклонников.', '1583760157.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`) VALUES
(3, '188.163.83.146', 'admin', '$2y$12$zOFjoCLsz4glU.MgRnTU/OJE4ykGh8NJFsHaAOfrhY4vIUVtjQqWO', 'admin@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1583240519, 1583760888, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(6, 3, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `main`
--
ALTER TABLE `main`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `main_captions`
--
ALTER TABLE `main_captions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `main_sections`
--
ALTER TABLE `main_sections`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Индексы таблицы `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `main`
--
ALTER TABLE `main`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `main_captions`
--
ALTER TABLE `main_captions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `main_sections`
--
ALTER TABLE `main_sections`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
