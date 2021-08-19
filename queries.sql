USE readme;

/* Задание: Напишите запросы для добавления информации в БД: */

/* добавляем существующих пользователей */
INSERT INTO user (login, user_name, email, password, avatar)
  VALUES
  ('larisa', 'Лариса', 'larisa@mail.ru', 'larisa2000', 'userpic-larisa-small.jpg'),
  ('vlad', 'Владик', 'vlad@mail.ru', 'vlad1500', 'userpic.jpg'),
  ('viktor', 'Виктор', 'viktor@mail.ru', 'vitek007', 'userpic-mark.jpg');

/* Задание: придумать новых пользователей */
INSERT INTO user (login, user_name, email, password)
VALUES
  ('anna', 'Аня', 'anna@mail.ru', 'anna17'),
  ('fedor', 'Федор', 'fedor@mail.ru', 'fedor3131');

/* Задание: добавить классы постов */
INSERT INTO content_type (name, class)
  VALUES
  ('Текст', 'text'),
  ('Цитата', 'quote'),
  ('Картинка', 'photo'),
  ('Видео', 'video'),
  ('Ссылка', 'link');

/* Задание: добавить существующие посты */
INSERT INTO post (title, text, quote_author, image, youtube, website, user_id, content_type_id)
  VALUES
  ('Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', 'Неизвестный Автор', NULL, NULL, NULL, 1, 2),
  ('Игра престолов', 'Не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала,  не могу дождаться начала финального сезона своего любимого сериала', NULL, NULL, NULL, NULL, 2, 1),
  ('Наконец, обработал фотки!', NULL, NULL, 'rock-medium.jpg', NULL, NULL, 3, 3),
  ('Моя мечта', NULL, NULL, 'coast-medium.jpg', NULL, NULL, 1, 3),
  ('Лучшие курсы', NULL, NULL, NULL, NULL, 'www.htmlacademy.ru', 2, 5);

/* Задание: придумать пару комментариев к существующим постам */
INSERT INTO comment (comment, user_id, post_id)
  VALUES
  ('отличные фотографии!', 5, 3),
  ('выкладывай еще фотографий', 1, 3),
  ('как раз прохожу их сейчас', 1, 5);



/* Задание: Напишите запросы для этих действий: */

/* Задание: добавить лайк к посту; */
INSERT INTO `like` (user_id, post_id)
  VALUES
  (1, 2),
  (1, 3),
  (2, 1),
  (2, 4),
  (3, 1),
  (3, 5),
  (4, 2),
  (4, 3),
  (5, 1);

/* Задание: подписаться на пользователя. */
INSERT INTO subscription (author_id, person_subscripted_id)
  VALUES
  (1, 3),
  (4, 2);

/* Задание: получить список постов для конкретного пользователя; */

SELECT p.*, us.user_name
FROM post p
INNER JOIN `user` us ON p.user_id = us.id
WHERE  us.user_name='Лариса';


/* Задание: получить список комментариев для одного поста, в комментариях должен быть логин пользователя; */
SELECT comment.comment, user.login, post.id
FROM comment
INNER JOIN `user` ON comment.user_id = user.id
INNER JOIN post ON comment.post_id = post.id
WHERE post_id = 3;

/* Задание: получить список постов с сортировкой по популярности и вместе с именами авторов и типом контента; */
/* если под популярностью понимается количество просмотров, то добавляем количество просмотров к постам */
UPDATE post SET views = 1 WHERE id = 1;
UPDATE post SET views = 2 WHERE id = 2;
UPDATE post SET views = 3 WHERE id = 3;
UPDATE post SET views = 4 WHERE id = 4;
UPDATE post SET views = 5 WHERE id = 5;

SELECT post.*, user.user_name, content_type.name
FROM post
INNER JOIN `user` ON post.user_id = user.id
INNER JOIN content_type ON post.content_type_id = content_type.id
ORDER BY views DESC;

/* а если под популярностью понимается количество лайков, что логичнее, то не понятно как сделать. По идее надо сначала сделать связь с таблицей лайков, правильно? А потом посчитать количество лайков у каждого поста и отсортировать по этому значению, но это какая то жесть */
