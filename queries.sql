-- получить список из всех категорий
SELECT name FROM category;

-- получить новейшие открытые лоты
SELECT lot.title, lot.initial_rate, lot.image, category.name AS category, MAX(bet.rate) AS rate, COUNT(bet.lot_id) AS bets
FROM lot
JOIN category ON lot.category_id = category.id
JOIN bet ON lot.id = bet.lot_id
WHERE lot.date_close > NOW() AND lot.winner_id IS NULL
GROUP BY lot.id
ORDER BY lot.date_add DESC;

-- найти лот по его названию или описанию
SELECT * FROM lot WHERE title LIKE '%Ботинки%' OR description LIKE '%Лучшие%';

-- добавить новый лот
INSERT INTO lot SET
  category_id  = 3,
  user_id      = 2,
  date_add     = NOW(),
  date_close   = '2017-05-30 00:00:00',
  title        = 'Крепления Union Contact Pro 2015 года размер L/XL',
  description  = 'Эргономичный хайбэк, амортизирующие вставки и, безусловно, лучшие стрепы и бакли в индустрии.',
  image        = 'img/lot-1.jpg',
  initial_rate = 8000,
  rate_step    = 200;

-- обновить название лота по id
UPDATE lot SET title = 'Куртка DC Mutiny Charocal' WHERE id = 5;

-- добавить новую ставку для лота
INSERT INTO bet SET
  lot_id   = 1,
  user_id  = 1,
  date_add = NOW(),
  rate     = 15000;

-- получить список ставок для лота по id
SELECT bet.date_add, bet.rate, user.id FROM bet
JOIN user ON bet.user_id = user.id
WHERE bet.lot_id = 1;
