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
SET reg_date = '2017-02-28 05:23:45', email = 'ponochevnii@mail.ru', password = 'q12345', name = 'Nikolay', contacts = 'tel. +79672370553';
INSERT INTO users
SET reg_date = '2016-06-02 21:19:00', email = 'aleksandra_priporova@rambler.ru', password = '54321A', name = 'Aleksandra Priporova', contacts = 'mail to Lyubertsy, Iniciativnaya 13-1270';
-- Добавляем объявления
INSERT INTO lots
SET creation_date = '2017-03-01', title = 'Отличные лыжи Рыбак 2110', description = 'Взрослые. Даже не пользовались!', image = 'first-lot.jpg', start_price = 4900, expire_date = '2017-03-08', price_increment = 100, author_id = 1, winner_id = 2, category_id = 1;
INSERT INTO lots
SET creation_date = '2018-05-09', title = 'Ботинки Футмэн', description = 'Отличные ботинки из кожи на меху.', image = 'second-lot.jpg', start_price = 3000, expire_date = '2018-06-01', price_increment = 80, author_id = 2, category_id = 3;
-- Добавляем ставки
INSERT INTO bids
SET date = '2017-03-01', bid = 5000, user_id = 2, lot_id = 1;
INSERT INTO bids
SET date = '2018-05-09', bid = 3080, user_id = 1, lot_id = 2;
-- Получаем все категории
SELECT * FROM categories;
-- Получаем новые открытые лоты
SELECT title, start_price, image, category_id FROM lots JOIN categories ON category_id = category WHERE expire_date <= NOW() ORDER BY creation_date DESC;
-- Показываем лот по его ID
SELECT * FROM lots WHERE id IN 10;
-- Обновляем название лота по ID
UPDATE lots SET title = 'Новое название' WHERE id IN 10;
-- Получаем список свежих ставок лота по ID
SELECT * FROM bids WHERE id IN 10 ORDER BY date;
