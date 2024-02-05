-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 26 2023 г., 12:25
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `komercheskaya firma`
--

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `carsalesreport`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `carsalesreport` (
`Фирма` varchar(100)
,`Наименование автомобиля` varchar(100)
,`Цена` int
,`Предпродажная подготовка` varchar(200)
,`Транспортная подготовка` int
,`Стоимость` double
);

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` int NOT NULL,
  `FIO` varchar(100) NOT NULL,
  `dogovor_number` int DEFAULT NULL,
  `buy_date` date DEFAULT NULL,
  `phone` int NOT NULL,
  `address` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `FIO`, `dogovor_number`, `buy_date`, `phone`, `address`) VALUES
(1, 'Иванов Иван Иванович', 12347, '2023-01-09', 234567890, 'ул. Примерная, 1'),
(2, 'Петрова Анна Сергеевна', 54321, '2023-01-09', 987654321, 'ул. Тестовая, 2'),
(3, 'Сидоров Павел Александрович', NULL, NULL, 876543210, 'ул. Проходная, 3'),
(4, 'Смирнова Ольга Ивановна', 98765, '2023-07-14', 123456789, 'ул. Тестовая, 4'),
(5, 'Кузнецов Михаил Петрович', 56789, '2023-03-16', 567890123, 'ул. Примерная, 5'),
(6, 'Алексеев Алексей Алексеевич', 123321, '2023-06-01', 161234572, 'Самара, Куйбышева 6'),
(7, 'Михайлов Михаил Михайлович', 7123, '2022-01-11', 161234573, 'Омск, Карла Либкнехта 7'),
(8, 'Андреев Андрей Андреевич', 8632, '2022-08-01', 161234574, 'Новосибирск, Челюскинцев 8'),
(9, 'Александров Александр Александрович', 190009, '2021-01-20', 161234575, 'Челябинск, Свердлова 9'),
(10, 'Сергеева Светлана Сергеевна', 123010, '2021-01-09', 161234576, 'Красноярск, Ленина 10'),
(11, 'Андреев Андрей Андреевич', NULL, NULL, 161234572, 'Самара, Куйбышева 6'),
(12, 'Андромедов Андромеда Васильевич', 87607, '2023-03-16', 161234573, 'Омск, Карла Либкнехта 7'),
(13, 'Гораскопов Скорпион Водолеевич', 444008, '2021-01-20', 161234574, 'Новосибирск, Челюскинцев 8'),
(14, 'Иванов Инвокер Санстрайкович', 900009, '2022-08-01', 161234575, 'Челябинск, Свердлова 9'),
(15, 'Слардар Сларк Суренович', 111010, '2021-01-09', 161234576, 'Красноярск, Ленина 10');

-- --------------------------------------------------------

--
-- Структура таблицы `models`
--

CREATE TABLE `models` (
  `id` int NOT NULL,
  `model_name` varchar(100) NOT NULL,
  `color` varchar(50) NOT NULL,
  `obivka` varchar(50) NOT NULL,
  `engine_power` int NOT NULL,
  `door_number` int NOT NULL,
  `korobka_peredach` varchar(100) NOT NULL,
  `id_postavshika` int NOT NULL,
  `flag` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `models`
--

INSERT INTO `models` (`id`, `model_name`, `color`, `obivka`, `engine_power`, `door_number`, `korobka_peredach`, `id_postavshika`, `flag`) VALUES
(1, 'Ford Focus', 'Красный', 'Кожа', 200, 4, 'Автомат', 1, 1),
(2, 'Honda', 'Синий', 'Ткань', 150, 4, 'Механика', 1, 1),
(3, 'Porsche Cayenne', 'Зеленый', 'Кожа', 180, 4, 'Автомат', 1, 1),
(4, 'Nissan', 'Черный', 'Кожа', 250, 4, 'Автомат', 4, 1),
(5, 'Volkswagen', 'Белый', 'Ткань', 120, 4, 'Механика', 5, 1),
(6, 'BMW X5', 'Черный', 'Кожа', 300, 5, 'Автомат', 10, 1),
(7, 'Audi Q7', 'Серебрянный', 'Кожа', 320, 5, 'Автомат', 5, 1),
(8, 'Mercedes Benz S-Class', 'Белый', 'Ткань', 360, 4, 'Автомат', 3, NULL),
(9, 'Porsche 911', 'Красный', 'Кожа', 400, 2, 'Механика', 4, 1),
(10, 'Lexus RX', 'Синий', 'Кожа', 275, 5, 'Автомат', 5, 1),
(11, 'Toyota Camry', 'Серебрянный', 'Ткань', 200, 4, 'Автомат', 6, 1),
(12, 'Volkswagen Passat', 'Черный', 'Кожа', 180, 4, 'Автомат', 7, 1),
(13, 'Honda Accord', 'Белый', 'Ткань', 180, 4, 'Автомат', 8, NULL),
(14, 'Nissan Juke', 'Красный', 'Ткань', 160, 5, 'Автомат', 9, 1),
(15, 'Hyundai Sonata', 'Красный', 'Кожа', 180, 4, 'Автомат', 10, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `posrednik`
--

CREATE TABLE `posrednik` (
  `id_model` int NOT NULL,
  `id_client` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `posrednik`
--

INSERT INTO `posrednik` (`id_model`, `id_client`) VALUES
(1, 1),
(2, 2),
(3, 5),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(7, 8),
(9, 9),
(10, 10),
(11, 8),
(12, 12),
(12, 13),
(14, 14),
(15, 15);

-- --------------------------------------------------------

--
-- Структура таблицы `postavshiki`
--

CREATE TABLE `postavshiki` (
  `id` int NOT NULL,
  `name_firma` varchar(100) NOT NULL,
  `phone` int DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `website` varchar(200) NOT NULL,
  `city` varchar(250) NOT NULL,
  `flag` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `postavshiki`
--

INSERT INTO `postavshiki` (`id`, `name_firma`, `phone`, `email`, `website`, `city`, `flag`) VALUES
(1, 'АвтоПрофи', 234567890, 'firma1@example.com', 'www.firma1.com', 'Краснодар', 1),
(2, 'МоторМаркет', 987654321, 'firma2@example.com', 'www.firma2.com', 'Ростов-на-Дону', 1),
(3, 'ДримКарс', 876543210, 'firma3@example.com', 'www.firma3.com', 'Пермь', 1),
(4, 'ПрестижАвто', 123456789, 'firma4@example.com', 'www.firma4.com', 'Воронеж', 1),
(5, 'ЭкспрессМоторс', 678901234, 'firma5@example.com', 'www.firma5.com', 'Азов', 1),
(6, 'Автоэксперт', 991827750, 'Firma6@example.com', 'www.firma6.com', 'Москва', 1),
(7, 'ГрандАвто', 583827750, 'Firma7@example.com', 'www.firma7.com', 'Москва', 1),
(8, 'КарКомпани', 195428750, 'Firma8@example.com', 'www.firma8.com', 'Ростов-на-Дону', 1),
(9, 'АвтоМастер', 981237550, 'Firma9@example.com', 'www.firma9.com', 'Краснодар', 1),
(10, 'ПрофессионалМоторс', 923847750, 'Firma10@example.com', 'www.firma10.com', 'Краснодар', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `price_list`
--

CREATE TABLE `price_list` (
  `id` int NOT NULL,
  `year_start` date NOT NULL,
  `coast` int NOT NULL,
  `podgotovka` varchar(200) NOT NULL,
  `transport_coast` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `price_list`
--

INSERT INTO `price_list` (`id`, `year_start`, `coast`, `podgotovka`, `transport_coast`) VALUES
(1, '2020-01-01', 80000, '200', 1500),
(2, '2018-01-01', 200000, '300', 200),
(3, '2019-01-01', 6000000, '250', 180),
(4, '2021-01-01', 600000, '400', 250),
(5, '2017-01-01', 500000, '500', 300),
(6, '2018-07-01', 20000, '1000.00', 500),
(7, '2021-02-01', 25000, '1500.00', 600),
(8, '2023-03-01', 30000, '2000.00', 700),
(9, '2022-04-01', 35000, '2500.00', 800),
(10, '2022-05-01', 40000, '3000.00', 900),
(11, '2019-06-01', 45000, '3500.00', 1000),
(12, '2015-07-01', 50000, '4000.00', 1100),
(13, '2020-08-01', 55000, '4500.00', 1200),
(14, '2020-09-01', 60000, '5000.00', 1300),
(15, '2022-11-11', 65000, '5500.00', 1400);

-- --------------------------------------------------------

--
-- Структура для представления `carsalesreport`
--
DROP TABLE IF EXISTS `carsalesreport`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `carsalesreport`  AS SELECT `postavshiki`.`name_firma` AS `Фирма`, `models`.`model_name` AS `Наименование автомобиля`, `price_list`.`coast` AS `Цена`, `price_list`.`podgotovka` AS `Предпродажная подготовка`, `price_list`.`transport_coast` AS `Транспортная подготовка`, ((`price_list`.`coast` + `price_list`.`podgotovka`) + `price_list`.`transport_coast`) AS `Стоимость` FROM (((`postavshiki` join `models` on((`postavshiki`.`id` = `models`.`id_postavshika`))) join `price_list` on((`models`.`id` = `price_list`.`id`))) join `posrednik` on((`models`.`id` = `posrednik`.`id_model`)))  ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_models_postavshiki` (`id_postavshika`) USING BTREE;

--
-- Индексы таблицы `posrednik`
--
ALTER TABLE `posrednik`
  ADD KEY `fk_clients_posrednik` (`id_model`),
  ADD KEY `fk_clients_posrednik1` (`id_client`);

--
-- Индексы таблицы `postavshiki`
--
ALTER TABLE `postavshiki`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `price_list`
--
ALTER TABLE `price_list`
  ADD PRIMARY KEY (`id`);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `models`
--
ALTER TABLE `models`
  ADD CONSTRAINT `fk_models_price_list` FOREIGN KEY (`id`) REFERENCES `price_list` (`id`),
  ADD CONSTRAINT `sv_models_postavshiki` FOREIGN KEY (`id_postavshika`) REFERENCES `postavshiki` (`id`);

--
-- Ограничения внешнего ключа таблицы `posrednik`
--
ALTER TABLE `posrednik`
  ADD CONSTRAINT `fk_clients_posrednik1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `fk_model_id` FOREIGN KEY (`id_model`) REFERENCES `models` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
