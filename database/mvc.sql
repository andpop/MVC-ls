-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 08 2018 г., 23:56
-- Версия сервера: 5.7.23-0ubuntu0.16.04.1
-- Версия PHP: 7.0.25-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mvc`
--

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE `files` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `files`
--

INSERT INTO `files` (`id`, `user_id`, `file_path`, `created_at`, `updated_at`) VALUES
(2, 6, 'img/6/work-1.png', '2018-09-08 17:20:39', '2018-09-08 17:20:39'),
(3, 6, 'img/6/work-2.png', '2018-09-08 17:20:54', '2018-09-08 17:20:54'),
(4, 6, 'img/6/work-3.png', '2018-09-08 18:27:12', '2018-09-08 18:27:12'),
(5, 6, 'img/6/work-3.png', '2018-09-08 18:30:00', '2018-09-08 18:30:00'),
(6, 6, 'img/6/work-1.png', '2018-09-08 18:30:13', '2018-09-08 18:30:13'),
(7, 7, 'img/7/work-2.png', '2018-09-08 18:52:49', '2018-09-08 18:52:49'),
(8, 7, 'img/7/author-full.jpg', '2018-09-08 19:20:18', '2018-09-08 19:20:18'),
(9, 7, 'img/7/reg-util.js', '2018-09-08 19:20:39', '2018-09-08 19:20:39');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `age`, `description`, `avatar_path`, `created_at`, `updated_at`) VALUES
(4, 'a', 'aaa', 'Вася', 44, 'екекекеке кекеке', 'img/avatars/work-1.png', '2018-09-06 21:14:00', '2018-09-06 21:14:00'),
(5, 'b', 'bbb', 'Андрей', 15, 'ывывук апекекеке', 'img/avatars/work-2.png', '2018-09-06 21:25:51', '2018-09-06 21:25:51'),
(6, 'd', '$2y$10$GyfShsvm.6s8/D99lD7cCuWZJBJr6/7/stdr5RNhjwDFXPsOjHB/u', 'Петя', 56, 'вауваапкекеке екекекеке', 'img/avatars/work-2.png', '2018-09-08 11:38:59', '2018-09-08 11:38:59'),
(7, 'andrey', '$2y$10$LBByQL8W8QkKF6wQ8JOS8ucjn4tsHqRRR6FkaVSfCt9IE3qaTEgbG', 'Андрей', 44, 'Много могу рассказать.', 'img/avatars/work-2.png', '2018-09-08 18:52:17', '2018-09-08 18:52:17'),
(8, 'fdicki', '$2y$10$h5Z9833EZovYDxiew6wLNONKEkFvTNvSJ3tZDlObFyxEr2UTlnSdG', 'Janae Abernathy', 57, 'Consequatur fugiat veniam nesciunt blanditiis omnis voluptatem. Explicabo eum unde at eligendi. Quis officia officiis nesciunt odit officia.', 'http://mvc/img/avatars/work-1.png', '1977-11-02 03:42:51', '2018-09-08 20:53:32'),
(9, 'stracke.verlie', '$2y$10$hc.WnN.bdSv3rsYpcrHxxOfTzBEU3aBEbaxs40PI4AIhvc4QChLIS', 'Eino Gulgowski', 86, 'Autem molestias excepturi et nisi at. Quibusdam recusandae recusandae voluptatem.', 'http://mvc/img/avatars/work-1.png', '1994-03-01 07:42:54', '2018-09-08 20:53:32'),
(10, 'cfahey', '$2y$10$woNJ41asdhKH.Oibaur9tOCWQ0u3ehkp1VChtQrtbP8uYm1OXU1.G', 'Ewald Corkery', 30, 'Consequuntur rem et dolorum officiis id consequuntur velit. Est praesentium impedit facere harum quos accusamus iure. Perferendis ipsa sint dolor possimus deleniti hic laborum.', 'http://mvc/img/avatars/work-1.png', '1970-04-06 09:29:10', '2018-09-08 20:53:32'),
(11, 'ima12', '$2y$10$CzLgprq1iG/FQEbzpDwh2OLjmpvfmJhqfAAlZeO/oArxt77X9Ka/u', 'Nyasia Ward Jr.', 119, 'Qui dolores quos ipsa sed laboriosam architecto quos eligendi. Voluptatem suscipit quibusdam nisi. Excepturi totam delectus omnis quo illo sunt reiciendis.', 'http://mvc/img/avatars/work-1.png', '2016-02-29 20:12:51', '2018-09-08 20:53:33'),
(12, 'jett.cole', '$2y$10$YrTiGkQCKxxu5VJDcAao8.2zetjGOeCh6zyF3lUzTLBM7tYznTdcu', 'Madalyn Collins', 8, 'Tempora rerum excepturi consequuntur harum expedita numquam sit. Et aut molestiae velit corrupti dolore et ipsam. Quia nam dicta officia dicta natus minus qui id.', 'http://mvc/img/avatars/work-1.png', '1990-05-15 08:36:49', '2018-09-08 20:53:33'),
(13, 'mikel34', '$2y$10$VhlulieRUV8gWPP0QPvCjeVXImibQQsLIvRmCt9ADz6p76qWOQuj.', 'Jean Orn II', 34, 'Placeat quia sit eligendi cum modi error. Voluptatem doloribus odio omnis ad blanditiis quia. Quia suscipit magni inventore quis expedita harum soluta.', 'http://mvc/img/avatars/work-1.png', '2004-01-23 11:24:28', '2018-09-08 20:53:33'),
(14, 'oadams', '$2y$10$BGodgMc4sjV/6.8nw6JlD./wKo5gzcOaXAOjPhfBBrZb6Dkl7G/me', 'Rachel Abshire Sr.', 89, 'Voluptatem eaque iure unde delectus rerum. Possimus in sed recusandae. Cum magni voluptatibus eveniet est.', 'http://mvc/img/avatars/work-1.png', '1981-10-04 09:46:04', '2018-09-08 20:53:33'),
(15, 'friesen.destiny', '$2y$10$ugvMlngBs4XXUD7IjrN4ceMX.vk0vtB876/RaNWUFIhZqz11Yln0C', 'Casper Harber', 24, 'Molestiae illo praesentium ex ut consequatur est omnis. Et sint perspiciatis suscipit accusantium qui. Ipsa totam similique omnis vero voluptas. Odit iusto pariatur qui vel ut.', 'http://mvc/img/avatars/work-1.png', '1998-05-01 11:43:04', '2018-09-08 20:53:33'),
(16, 'patience84', '$2y$10$XVSQ1v.btUI0IZ1IDBkcBeJSHTuPfJrALy4cRHCXRFxRYF.V.5S8m', 'Sedrick Cartwright', 102, 'Aperiam sunt delectus est molestias placeat numquam. Incidunt architecto nobis cum. Corrupti alias rem magnam aliquam. Voluptate inventore consectetur voluptatem fuga magni adipisci.', 'http://mvc/img/avatars/work-1.png', '2016-08-21 00:58:34', '2018-09-08 20:53:33'),
(17, 'ricardo.greenfelder', '$2y$10$x7kvSNFvqlt45BOCKY/oTOrurSfHX6/frAzKuohlYLrq6HVbwrh2.', 'Miss Daphne Gleichner', 97, 'Et quibusdam dolor sint consequuntur. Nemo consequatur quo provident quam atque consequuntur quia. Veritatis earum eos enim assumenda nam error atque.', 'http://mvc/img/avatars/work-1.png', '2001-12-01 22:11:30', '2018-09-08 20:53:33');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
