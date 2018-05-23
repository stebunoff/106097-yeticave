-- Добавляем категории
INSERT INTO categories
SET category = 'Доски и лыжи', class = 'boards';
INSERT INTO categories
SET category = 'Крепления', class = 'attachment';
INSERT INTO categories
SET category = 'Ботинки', class = 'boots';
INSERT INTO categories
SET category = 'Одежда', class = 'clothing';
INSERT INTO categories
SET category = 'Инструменты', class = 'tools';
INSERT INTO categories
SET category = 'Разное', class = 'other';
-- Добавляем пользователей
INSERT INTO users
SET reg_datetime = '2017-02-28 05:23:45', email = 'ponochevnii@mail.ru', password = 'q12345', name = 'Nikolay', contacts = 'tel. +79672370553';
INSERT INTO users
SET reg_datetime = '2016-06-02 21:19:00', email = 'aleksandra_priporova@rambler.ru', password = '54321A', name = 'Aleksandra Priporova', contacts = 'mail to Lyubertsy, Iniciativnaya 13-1270';
INSERT INTO users
SET reg_datetime = '2018-05-01 15:00:45', email = 'mail@mail.ru', password = 'xddqd', name = 'Iliya', contacts = 'tel. +7967123456';
-- Добавляем объявления
INSERT INTO lots
SET creation_datetime = NOW(), title = 'Маска Oakley Canopy', image = 'lot-6.jpg', start_price = 5400, expire_datetime = '2018-06-15 14:00:50', price_increment = 100, author_id = 1, category_id = 6;
INSERT INTO lots
SET creation_datetime = NOW(), title = 'Куртка для сноуборда DC Mutiny Charocal', image = 'lot-5.jpg', start_price = 7500, expire_datetime = '2018-06-16 14:02:50', price_increment = 100, author_id = 2, category_id = 4;
INSERT INTO lots
SET creation_datetime = NOW(), title = 'Ботинки для сноуборда DC Mutiny Charocal', image = 'lot-4.jpg', start_price = 10999, expire_datetime = '2018-06-17 15:00:50', price_increment = 150, author_id = 1, category_id = 3;
INSERT INTO lots
SET creation_datetime = NOW(), title = 'Крепления Union Contact Pro 2015 года размер L/XL', image = 'lot-3.jpg', start_price = 8000, expire_datetime = '2018-06-18 16:20:50', price_increment = 50, author_id = 2, category_id = 2;
INSERT INTO lots
SET creation_datetime = NOW(), title = 'DC Ply Mens 2016/2017 Snowboard', image = 'lot-2.jpg', start_price = 159999, expire_datetime = '2018-06-19 12:01:10', price_increment = 1000, author_id = 1, category_id = 1;
INSERT INTO lots
SET creation_datetime = NOW(), title = '2014 Rossignol District Snowboard', image = 'lot-1.jpg', start_price = 10999, expire_datetime = '2018-07-01 01:01:10', price_increment = 200, author_id = 2, category_id = 1;
-- Добавляем ставки
INSERT INTO bids
SET datetime = '2018-05-19 23:00:01', bid = 5500, author_id = 2, lot_id = 1;
INSERT INTO bids
SET datetime = '2018-05-21 19:00:01', bid = 5600, author_id = 3, lot_id = 1;
INSERT INTO bids
SET datetime = '2018-05-21 23:00:01', bid = 6000, author_id = 2, lot_id = 1;
INSERT INTO bids
SET datetime = '2018-05-20 05:55:01', bid = 7700, author_id = 1, lot_id = 2;
INSERT INTO bids
SET datetime = '2018-05-21 10:03:11', bid = 7900, author_id = 3, lot_id = 2;
INSERT INTO bids
SET datetime = '2018-05-19 23:00:01', bid = 11199, author_id = 1, lot_id = 6;
INSERT INTO bids
SET datetime = '2018-05-20 05:55:01', bid = 11399, author_id = 3, lot_id = 6;
INSERT INTO bids
SET datetime = '2018-05-21 10:03:11', bid = 11999, author_id = 1, lot_id = 6;
-- Получаем все категории
SELECT * FROM categories;
-- Получаем новые открытые лоты
SELECT l.title, l.start_price, l.image, l.category_id, c.category, COUNT(b.id) AS bids_number, l.start_price + l.price_increment * COUNT(b.id) AS price FROM lots l JOIN categories c ON c.id = l.category_id JOIN bids b ON l.id = b.lot_id WHERE l.expire_datetime <= NOW() GROUP BY b.lot_id ORDER BY l.creation_datetime DESC;
-- Показываем лот по его ID
SELECT l.*, c.category FROM lots l JOIN categories c ON c.id = l.category_id WHERE l.id = 1;
-- Обновляем название лота по ID
-- UPDATE lots SET title = 'Новое название' WHERE id = 2;
-- Получаем список свежих ставок лота по ID
SELECT * FROM bids WHERE lot_id = 2 ORDER BY datetime DESC;
