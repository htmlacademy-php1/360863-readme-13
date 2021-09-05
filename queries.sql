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
INSERT INTO posts (title, text, quote_author, image, youtube, website_title, website, user_id, content_type_id)
VALUES
  ('Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', 'Неизвестный Автор', NULL, NULL, NULL, NULL, 1, 2),
  ('Игра престолов', 'Не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала,  не могу дождаться начала финального сезона своего любимого сериала', NULL, NULL, NULL, NULL, NULL, 2, 1),
  ('Наконец, обработал фотки!', NULL, NULL, 'rock-medium.jpg', NULL, NULL, NULL, 3, 3),
  ('Моя мечта', NULL, NULL, 'coast-medium.jpg', NULL, NULL, NULL, 1, 3),
  ('Лучшие курсы', NULL, NULL, NULL, NULL, 'Лучшие курсы', 'www.htmlacademy.ru', 2, 5);

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

SELECT * FROM posts WHERE user_id = 1;



/* Задание: получить список комментариев для одного поста, в комментариях должен быть логин пользователя; */
SELECT comment.comment, user.login
FROM comment
       INNER JOIN `user` ON comment.user_id = user.id
WHERE comment.post_id = 3;

/* Задание: получить список постов с сортировкой по популярности и вместе с именами авторов и типом контента; */
/* если под популярностью понимается количество просмотров, то добавляем количество просмотров к постам */
UPDATE posts SET views = 1 WHERE id = 1;
UPDATE posts SET views = 2 WHERE id = 2;
UPDATE posts SET views = 3 WHERE id = 3;
UPDATE posts SET views = 4 WHERE id = 4;
UPDATE posts SET views = 5 WHERE id = 5;

SELECT posts.*, user.user_name, content_type.name
FROM posts
       INNER JOIN `user` ON posts.user_id = user.id
       INNER JOIN content_type ON posts.content_type_id = content_type.id
ORDER BY views DESC;

/* а если под популярностью понимается количество лайков, что логичнее, то не понятно как сделать. По идее надо сначала сделать связь с таблицей лайков, правильно? А потом посчитать количество лайков у каждого поста и отсортировать по этому значению, но это какая то жесть */
SELECT posts.*, user.user_name, content_type.name
FROM posts
       INNER JOIN `user` ON posts.user_id = user.id
       INNER JOIN content_type ON posts.content_type_id = content_type.id
       LEFT JOIN `like` ON `like`.post_id = posts.id
GROUP BY posts.id
ORDER BY COUNT(`like`.id) DESC;


/* Добавляем хэштеги */
INSERT INTO hashtag (hashtag)
VALUES
  ('#nature'),
  ('#globe'),
  ('#photooftheday'),
  ('#canon'),
  ('#landscape'),
  ('#щикарныйвид');




/* Добавляем хэштеги к посту*/

INSERT INTO post_hashtags (post_id, hashtag_id)
VALUES
  (3, 1),
  (3, 2),
  (3, 3),
  (3, 4),
  (3, 5),
  (3, 6);

/* Добавляем подписчиков */

INSERT INTO subscription (author_id, person_subscripted_id)
VALUES
  (3, 1),
  (3, 2);

INSERT INTO subscription (author_id, person_subscripted_id)
VALUES
  (1, 2);

INSERT INTO subscription (author_id, person_subscripted_id)
VALUES
  (2, 1),
  (2, 3);

/* Добавляем подписчиков */

INSERT INTO `like` (user_id, post_id)
VALUES
  (1, 3),
  (2, 3),
  (3, 1),
  (1, 5),
  (1, 4);


/* Добавляем репосты */

INSERT INTO repost (user_id, post_id)
VALUES
  (1, 3),
  (2, 3),
  (3, 1),
  (1, 2),
  (3, 5);

/* Добавляем комментарии */

INSERT INTO comment (comment, user_id, post_id)
VALUES
  ('Красота!!!!', 1, 3),
  ('Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках', 1, 3);


INSERT INTO comment (comment, user_id, post_id)
VALUES
  ('Тоже там был прошлой зимой', 4, 3);

INSERT INTO `like` (user_id, post_id)
VALUES
  (1, 3),
  (2, 3),
  (1, 4),
  (3, 5),
  (4, 1),
  (4, 3),
  (2, 1);
