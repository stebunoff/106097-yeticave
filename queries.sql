-- Добавляем категории
INSERT INTO categories
SET category = 'Доски и лыжи';
INSERT INTO categories
SET category = 'Крепления';
INSERT INTO categories
SET category = 'Ботинки';
INSERT INTO categories
SET category = 'Одежда';
INSERT INTO categories
SET category = 'Инструменты';
INSERT INTO categories
SET category = 'Разное';
-- Добавляем пользователей
INSERT INTO users
SET reg_datetime = '2017-02-28 05:23:45', email = 'ponochevnii@mail.ru', password = 'q12345', name = 'Nikolay', contacts = 'tel. +79672370553';
INSERT INTO users
SET reg_datetime = '2016-06-02 21:19:00', email = 'aleksandra_priporova@rambler.ru', password = '54321A', name = 'Aleksandra Priporova', contacts = 'mail to Lyubertsy, Iniciativnaya 13-1270';
-- Добавляем объявления
INSERT INTO lots
SET creation_datetime = '2017-03-01', title = 'Отличные лыжи Рыбак 2110', description = 'Взрослые. Даже не пользовались!', image = 'first-lot.jpg', start_price = 4900, expire_datetime = '2017-03-08', price_increment = 100, author_id = 1, winner_id = 2, category_id = 1;
INSERT INTO lots
SET creation_datetime = '2018-05-09', title = 'Ботинки Футмэн', description = 'Отличные ботинки из кожи на меху.', image = 'second-lot.jpg', start_price = 3000, expire_datetime = '2018-06-01', price_increment = 80, author_id = 2, category_id = 3;
-- Добавляем ставки
INSERT INTO bids
SET datetime = '2017-03-01', bid = 5000, author_id = 2, lot_id = 1;
INSERT INTO bids
SET datetime = '2018-05-09', bid = 3080, author_id = 1, lot_id = 2;
-- Получаем все категории
SELECT * FROM categories;
-- Получаем новые открытые лоты
SELECT l.title, l.start_price, l.image, l.category_id, c.category, COUNT(b.id) AS bids_number, l.start_price + l.price_increment * COUNT(b.id) AS price FROM lots l JOIN categories c ON c.id = l.category_id JOIN bids b ON l.id = b.lot_id GROUP BY b.lot_id WHERE l.expire_datetime <= NOW() ORDER BY l.creation_datetime DESC;
-- Показываем лот по его ID
SELECT * FROM lots l JOIN categories c ON c.id = l.category_id WHERE l.id = 1;
-- Обновляем название лота по ID
UPDATE lots SET title = 'Новое название' WHERE id = 2;
-- Получаем список свежих ставок лота по ID
SELECT * FROM bids WHERE id = 1 ORDER BY date;
