-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 03 2020 г., 19:11
-- Версия сервера: 8.0.15
-- Версия PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `library`
--

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `idbook` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` text,
  `author` varchar(45) DEFAULT NULL,
  `idgenre` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `electronic_src` text,
  `uuid` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `books_archive`
--

CREATE TABLE `books_archive` (
  `idbook` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` text,
  `author` varchar(45) DEFAULT NULL,
  `idgenre` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `electronic_src` text,
  `uuid` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `genres`
--

CREATE TABLE `genres` (
  `idgenre` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE `menu` (
  `idmenu` int(11) NOT NULL,
  `title` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `url` varchar(90) DEFAULT NULL,
  `permissions` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`idmenu`, `title`, `url`, `permissions`) VALUES
(1, 'Главная', '/', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `permissions`
--

CREATE TABLE `permissions` (
  `idpermission` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `permissions`
--

INSERT INTO `permissions` (`idpermission`, `name`) VALUES
(1, 'Общий доступ');

-- --------------------------------------------------------

--
-- Структура таблицы `rented_books`
--

CREATE TABLE `rented_books` (
  `idrented` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `idbook` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `idrole` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `permissions` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`idrole`, `name`, `permissions`) VALUES
(1, 'Администратор', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `iduser` int(11) NOT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `idrole` int(11) DEFAULT NULL,
  `mail` varchar(60) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`iduser`, `surname`, `name`, `middle_name`, `idrole`, `mail`, `password`, `token`) VALUES
(1, 'Минаков', 'Александр', 'Андреевич', 1, 'sasha_17082001@mail.ru', '5f1bc1cc080a9edd2f002274aad73433', 'XsX2pfKHTzFOJ4kzsOqr57OLjLghHtu3');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`idbook`),
  ADD KEY `fk_books_genres1_idx` (`idgenre`);

--
-- Индексы таблицы `books_archive`
--
ALTER TABLE `books_archive`
  ADD PRIMARY KEY (`idbook`),
  ADD KEY `fk_books_genres1_idx` (`idgenre`);

--
-- Индексы таблицы `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`idgenre`);

--
-- Индексы таблицы `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmenu`);

--
-- Индексы таблицы `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`idpermission`);

--
-- Индексы таблицы `rented_books`
--
ALTER TABLE `rented_books`
  ADD PRIMARY KEY (`idrented`),
  ADD KEY `fk_rented_books_books1_idx` (`idbook`),
  ADD KEY `fk_rented_books_users1_idx` (`iduser`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idrole`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iduser`),
  ADD KEY `fk_users_roles_idx` (`idrole`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `menu`
--
ALTER TABLE `menu`
  MODIFY `idmenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `permissions`
--
ALTER TABLE `permissions`
  MODIFY `idpermission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_genres1` FOREIGN KEY (`idgenre`) REFERENCES `genres` (`idgenre`);

--
-- Ограничения внешнего ключа таблицы `books_archive`
--
ALTER TABLE `books_archive`
  ADD CONSTRAINT `fk_books_genres10` FOREIGN KEY (`idgenre`) REFERENCES `genres` (`idgenre`);

--
-- Ограничения внешнего ключа таблицы `rented_books`
--
ALTER TABLE `rented_books`
  ADD CONSTRAINT `fk_rented_books_books1` FOREIGN KEY (`idbook`) REFERENCES `books` (`idbook`),
  ADD CONSTRAINT `fk_rented_books_users1` FOREIGN KEY (`iduser`) REFERENCES `users` (`iduser`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_roles` FOREIGN KEY (`idrole`) REFERENCES `roles` (`idrole`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
