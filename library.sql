-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 25 2021 г., 17:29
-- Версия сервера: 8.0.15
-- Версия PHP: 7.3.2

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
  `year` int(4) DEFAULT NULL,
  `idlanguage` int(11) DEFAULT NULL,
  `pages` int(11) DEFAULT NULL,
  `publisher` varchar(45) DEFAULT NULL,
  `city_print` varchar(45) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `electronic_src` text,
  `cover` varchar(150) DEFAULT NULL,
  `uuid` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`idbook`, `name`, `description`, `author`, `idgenre`, `year`, `idlanguage`, `pages`, `publisher`, `city_print`, `count`, `electronic_src`, `cover`, `uuid`) VALUES
(9, 'Параша Лупалова', 'История жизни необыкновенной и неустрашимой девушки, которая совершила высокий подвиг самоотвержения, и пешком пришла из Сибири в Петербург просить у Государя помилования своему отцу.', 'Местр Ксавье де', 2, 1864, 1, 13, 'Изданiе т-ва М. О. Вольфъ', 'Санкт-Петербург', 0, '/uploads/electronic_books/1288d2u8usad.fb2', '/uploads/books/sdjaisdjaisd1213.jpg', '1213aad'),
(21, 'Программирование на Python для начинающих', 'Книга \"Программирование на Python для начинающих\" является исчерпывающим руководством для того, чтобы научиться программировать на языке Python. В этой книге с помощью примеров программ и иллюстраций, показывающих результаты работы кода, разбираются все ключевые аспекты языка. Установив свободно распространяемый интерпретатор Python, вы с первого же дня сможете создавать свои собственные исполняемые программы! Познакомившись с основами языка, вы перейдете к объектно-ориентированному программированию и созданию CGI-сценариев для обработки данных веб-форм, научитесь создавать графические приложения с оконным интерфейсом и распространять их на другие устройства. В обучении вам помогут готовые примеры. Книга «Программирование на Python для начинающих» идеально подойдет программистам, переключающимся на работу с другим языком, студентам и школьникам изучающим язык Python. Самое важное: - функции - переменные - ключевые слова - методы - объекты - операторы - атрибуты - запросы - и многое другое отзыв: Отличный старт для решивших начать изучать программирование с Python. Даже если вы никогда до этого не создавали программы, с помощью этой книги вы сможете пройти все шаги от установки интерпретатора до запуска и отладки своих первых приложений.  Александр Корчагин, Руководитель отдела финансовых информационных систем, Центральная Дистрибьюторская Компания', 'МакГрат Майк', 3, 2015, 1, 120, 'ООО Издательство Эксмо', 'Москва', 0, '/uploads/electronic_books/60aa23d719490.tmp', '/uploads/books/60aa23d7196a0.png', '123asdsa1');

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
  `year` int(4) DEFAULT NULL,
  `idlanguage` int(11) DEFAULT NULL,
  `pages` int(11) DEFAULT NULL,
  `publisher` varchar(45) DEFAULT NULL,
  `city_print` varchar(45) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `electronic_src` text,
  `cover` varchar(150) DEFAULT NULL,
  `uuid` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books_archive`
--

INSERT INTO `books_archive` (`idbook`, `name`, `description`, `author`, `idgenre`, `year`, `idlanguage`, `pages`, `publisher`, `city_print`, `count`, `electronic_src`, `cover`, `uuid`) VALUES
(6, 'C++ для &quot;чайников&quot;', '&quot;Моим друзьям и семье, которые помогли мне стать &quot;чайником &quot; в еще большей степени, чем я есть на самом деле&quot;.  (Стефан Р. Дэвис)', 'Стефан Рэнди Дэвис', 3, 2003, 1, 15, 'Диалектика', 'Москва, Санкт-Петербург, Киев', 0, '/uploads/electronic_books/5fdb8b43b4514.tmp', '/uploads/books/5fdb8b43b485a.png', 'АЫФВ12'),
(8, 'Параша Лупалова', 'История жизни необыкновенной и неустрашимой девушки, которая совершила высокий подвиг самоотвержения, и пешком пришла из Сибири в Петербург просить у Государя помилования своему отцу.', 'Местр Ксавье де', 2, 1864, 1, 13, 'Изданiе т-ва М. О. Вольфъ', 'Санкт-Петербург', 10, '', '/uploads/books/sdjaisdjaisd1213.jpg', '1213aad'),
(9, 'HTML и CSS. Разработка и дизайн веб-сайтов', 'Эта книга – самый простой и интересный способ изучить HTML и CSS. Независимо от стоящей перед вами задачи: спроектировать и разработать веб-сайт с нуля или получить больше контроля над уже существующим сайтом, эта книга поможет вам создать привлекательный, дружелюбный к пользователю веб-контент. Простой визуальный способ подачи информации с понятными примерами и небольшим фрагментом кода знакомит с новой темой на каждой странице. Вы найдете практические советы о том, как организовать и спроектировать страницы вашего сайта, и после прочтения книги сможете разработать свой веб-сайт профессионального вида и удобный в использовании.', 'Дакетт Джон', 3, 2016, 1, 100, '', '', 5, '/uploads/electronic_books/sdajisdj1213s.pdf', '/uploads/books/sjdhasudhuasd.jpg', 'sdasd123'),
(10, 'Параша Лупалова', 'История жизни необыкновенной и неустрашимой девушки, которая совершила высокий подвиг самоотвержения, и пешком пришла из Сибири в Петербург просить у Государя помилования своему отцу.', 'Местр Ксавье де', 2, 1864, 1, 13, 'Изданiе т-ва М. О. Вольфъ', 'Санкт-Петербург', 0, '/uploads/electronic_books/1288d2u8usad.fb2', '/uploads/books/sdjaisdjaisd1213.jpg', '1213aad'),
(11, 'Параша Лупалова', 'История жизни необыкновенной и неустрашимой девушки, которая совершила высокий подвиг самоотвержения, и пешком пришла из Сибири в Петербург просить у Государя помилования своему отцу.', 'Местр Ксавье де', 2, 1864, 1, 13, 'Изданiе т-ва М. О. Вольфъ', 'Санкт-Петербург', 0, '/uploads/electronic_books/1288d2u8usad.fb2', '/uploads/books/sdjaisdjaisd1213.jpg', '1213aad'),
(12, 'ывфывыф', 'ыфвфывф', 'ыфвфыв', 2, 2021, 1, 2, 'ывфы', 'фывфыв', 2, '/uploads/electronic_books/607d880df02b7.tmp', '/uploads/books/607d880df0518.png', 'фывыфв12');

-- --------------------------------------------------------

--
-- Структура таблицы `favorites`
--

CREATE TABLE `favorites` (
  `idfavorite` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `idbook` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `favorites`
--

INSERT INTO `favorites` (`idfavorite`, `iduser`, `idbook`) VALUES
(69, 2, 21),
(70, 5, 21);

-- --------------------------------------------------------

--
-- Структура таблицы `genres`
--

CREATE TABLE `genres` (
  `idgenre` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `genres`
--

INSERT INTO `genres` (`idgenre`, `name`) VALUES
(2, 'Русская классическая проза'),
(3, 'Программирование'),
(4, 'Боевики');

-- --------------------------------------------------------

--
-- Структура таблицы `languages`
--

CREATE TABLE `languages` (
  `idlanguage` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `languages`
--

INSERT INTO `languages` (`idlanguage`, `name`) VALUES
(1, 'Русский'),
(2, 'Английский');

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
(1, 'Главная', '/', '1'),
(2, 'Панель управления', '/admin', '2'),
(3, 'Каталог книг', '/books', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `menu_admin`
--

CREATE TABLE `menu_admin` (
  `idmenu` int(11) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `url` varchar(90) DEFAULT NULL,
  `permissions` varchar(120) DEFAULT NULL,
  `idgroup` int(11) DEFAULT NULL,
  `icon` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `menu_admin`
--

INSERT INTO `menu_admin` (`idmenu`, `title`, `url`, `permissions`, `idgroup`, `icon`) VALUES
(1, 'Добавление книг', '/admin/electronic_books', '2', 1, '/uploads/admin_menu/add_book.png'),
(7, 'Книги', '/admin/books', '2', 1, '/uploads/admin_menu/books.png'),
(8, 'Пользователи', '/admin/users', '2', 3, '/uploads/admin_menu/users.png'),
(9, 'Арендованные книги', '/admin/rent', '2', 1, '/uploads/admin_menu/talon.png');

-- --------------------------------------------------------

--
-- Структура таблицы `menu_admin_group`
--

CREATE TABLE `menu_admin_group` (
  `idgroup` int(11) NOT NULL,
  `title` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `menu_admin_group`
--

INSERT INTO `menu_admin_group` (`idgroup`, `title`) VALUES
(1, 'Книги'),
(3, 'Пользователи');

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
(1, 'Общий доступ'),
(2, 'Доступ к панели управления');

-- --------------------------------------------------------

--
-- Структура таблицы `rented_books`
--

CREATE TABLE `rented_books` (
  `idrented` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `idbook` int(11) DEFAULT NULL,
  `date_capture` date DEFAULT NULL,
  `date_return` date DEFAULT NULL,
  `idstatus` int(11) DEFAULT '1'
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
(1, 'Администратор', '1,2'),
(2, 'Пользователь', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `idstatus` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`idstatus`, `name`) VALUES
(1, 'В обработке'),
(5, 'Возвращено'),
(3, 'Выдано'),
(2, 'Готово к выдаче'),
(4, 'Ожидается возврат');

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
(2, 'Админов', 'Админ', 'Админович', 1, 'admin@library.ru', '5f1bc1cc080a9edd2f002274aad73433', 'FFkNvVdz0oAcvtTLjp48KuxSECyRCeDR'),
(4, 'Анатолий', 'Александрович', 'Волков', 2, 'volkov.tolya@mail.ru', 'e10adc3949ba59abbe56e057f20f883e', 'rZ8l1BdCNHLYZnvPSPnwZOx2Wq69opyH'),
(5, 'Минаков', 'Александр', 'Андреевич', 2, 'alexsandr.minakov@mail.ru', 'e10adc3949ba59abbe56e057f20f883e', 'XE8qLSATGgVXzkjMS1I3w1hGaV0MunpJ');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`idbook`),
  ADD KEY `fk_books_genres1_idx` (`idgenre`),
  ADD KEY `fk_books_languages1_idx` (`idlanguage`);

--
-- Индексы таблицы `books_archive`
--
ALTER TABLE `books_archive`
  ADD PRIMARY KEY (`idbook`),
  ADD KEY `fk_books_genres1_idx` (`idgenre`),
  ADD KEY `fk_books_languages1_idx` (`idlanguage`);

--
-- Индексы таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`idfavorite`),
  ADD KEY `fk_favorites_users1_idx` (`iduser`),
  ADD KEY `fk_favorites_books1_idx` (`idbook`);

--
-- Индексы таблицы `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`idgenre`);

--
-- Индексы таблицы `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`idlanguage`);

--
-- Индексы таблицы `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmenu`);

--
-- Индексы таблицы `menu_admin`
--
ALTER TABLE `menu_admin`
  ADD PRIMARY KEY (`idmenu`),
  ADD KEY `fk_menu_admin_menu_admin_group1_idx` (`idgroup`);

--
-- Индексы таблицы `menu_admin_group`
--
ALTER TABLE `menu_admin_group`
  ADD PRIMARY KEY (`idgroup`);

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
  ADD KEY `fk_rented_books_users1_idx` (`iduser`),
  ADD KEY `fk_rented_books_statuses1_idx` (`idstatus`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idrole`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`idstatus`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

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
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `idbook` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `books_archive`
--
ALTER TABLE `books_archive`
  MODIFY `idbook` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `favorites`
--
ALTER TABLE `favorites`
  MODIFY `idfavorite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT для таблицы `genres`
--
ALTER TABLE `genres`
  MODIFY `idgenre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `languages`
--
ALTER TABLE `languages`
  MODIFY `idlanguage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `menu`
--
ALTER TABLE `menu`
  MODIFY `idmenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `menu_admin`
--
ALTER TABLE `menu_admin`
  MODIFY `idmenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `menu_admin_group`
--
ALTER TABLE `menu_admin_group`
  MODIFY `idgroup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `permissions`
--
ALTER TABLE `permissions`
  MODIFY `idpermission` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `rented_books`
--
ALTER TABLE `rented_books`
  MODIFY `idrented` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `idrole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `idstatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_genres1` FOREIGN KEY (`idgenre`) REFERENCES `genres` (`idgenre`),
  ADD CONSTRAINT `fk_books_languages1` FOREIGN KEY (`idlanguage`) REFERENCES `languages` (`idlanguage`);

--
-- Ограничения внешнего ключа таблицы `books_archive`
--
ALTER TABLE `books_archive`
  ADD CONSTRAINT `fk_books_genres10` FOREIGN KEY (`idgenre`) REFERENCES `genres` (`idgenre`),
  ADD CONSTRAINT `fk_books_languages10` FOREIGN KEY (`idlanguage`) REFERENCES `languages` (`idlanguage`);

--
-- Ограничения внешнего ключа таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `fk_favorites_books1` FOREIGN KEY (`idbook`) REFERENCES `books` (`idbook`),
  ADD CONSTRAINT `fk_favorites_users1` FOREIGN KEY (`iduser`) REFERENCES `users` (`iduser`);

--
-- Ограничения внешнего ключа таблицы `menu_admin`
--
ALTER TABLE `menu_admin`
  ADD CONSTRAINT `fk_menu_admin_menu_admin_group1` FOREIGN KEY (`idgroup`) REFERENCES `menu_admin_group` (`idgroup`);

--
-- Ограничения внешнего ключа таблицы `rented_books`
--
ALTER TABLE `rented_books`
  ADD CONSTRAINT `fk_rented_books_books1` FOREIGN KEY (`idbook`) REFERENCES `books` (`idbook`),
  ADD CONSTRAINT `fk_rented_books_statuses1` FOREIGN KEY (`idstatus`) REFERENCES `statuses` (`idstatus`),
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
