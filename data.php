<?php
$isAuth = rand(0, 1);
$userName = 'Леонид'; // укажите здесь ваше имя
/*$posts = [
    [
        'title_post' => 'Цитата',
        'type_post' => 'post-quote',
        'content_post' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
        'username_post' => 'Лариса',
        'avatar_post' => 'userpic-larisa-small.jpg',
    ],
    [
        'title_post' => 'Игра престолов',
        'type_post' => 'post-text',
        'content_post' => 'Не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала, не могу дождаться начала финального сезона своего любимого сериала,  не могу дождаться начала финального сезона своего любимого сериала',
        'username_post' => 'Владик',
        'avatar_post' => 'userpic.jpg',
    ],
    [
        'title_post' => 'Наконец, обработал фотки!',
        'type_post' => 'post-photo',
        'content_post' => 'rock-medium.jpg',
        'username_post' => 'Виктор',
        'avatar_post' => 'userpic-mark.jpg',
    ],
    [
        'title_post' => 'Моя мечта',
        'type_post' => 'post-photo',
        'content_post' => 'coast-medium.jpg',
        'username_post' => 'Лариса',
        'avatar_post' => 'userpic-larisa-small.jpg',
    ],
    [
        'title_post' => 'Лучшие курсы',
        'type_post' => 'post-link',
        'content_post' => 'www.htmlacademy.ru',
        'username_post' => 'Владик',
        'avatar_post' => 'userpic.jpg',
    ],
];*/

$link = mysqli_connect('localhost', 'root', '', 'readme');
mysqli_set_charset($link, "utf8");

$contentTypeCondition = isset($_GET['class'])
    ? "WHERE posts.content_type_id = {$_GET['class']}" : '';

$sortDirection = $_GET['sort'] ?? 'ASC';
/*if (isset($_GET['sort'])) {
    $sortDirection = $_GET['sort'];
} else {
    $sortDirection = 'ASC';
}*/



$sqlPost = <<<SQL
SELECT
       posts.id,
       title post_title,
       text post_text,
       quote_author post_quote_author,
       image post_image,
       youtube post_youtube,
       website_title post_website_title,
       website post_website,
       views post_views,
       user.user_name user_name,
       user.avatar user_avatar,
       content_type.class content_class
FROM posts
INNER JOIN `user` ON posts.user_id = user.id
INNER JOIN content_type ON posts.content_type_id = content_type.id
{$contentTypeCondition}
ORDER BY views {$sortDirection};
SQL;

$resultPost = mysqli_query($link, $sqlPost);
$rows = mysqli_fetch_all($resultPost, MYSQLI_ASSOC);


$sqlContentType = <<<SQL
SELECT *
FROM content_type
SQL;

$resultContentType = mysqli_query($link, $sqlContentType);
$rowsContents = mysqli_fetch_all($resultContentType, MYSQLI_ASSOC);


$paramsIndex = $_GET;
$paramsIndex['sort'] = $sortDirection == 'ASC' ? 'DESC' : 'ASC';
$scriptNameIndex = pathinfo('index.php', PATHINFO_BASENAME);
$urlQueryIndex = http_build_query($paramsIndex);
$urlSort = "/" . $scriptNameIndex . "?" . $urlQueryIndex;


/* Создаем массив для страницы поста к самому посту*/
$postNumberId = isset($_GET['id']) ? "WHERE posts.id = {$_GET['id']}" : '';

$sqlPostNumber = <<<SQL
SELECT
       posts.id post_id,
       title post_title,
       text post_text,
       quote_author post_quote_author,
       image post_image,
       youtube post_youtube,
       website_title post_website_title,
       website post_website,
       views post_views,
       user.user_name user_name,
       user.avatar user_avatar,
       user.id user_id,
       user.created_at,
       content_type.class content_class
FROM posts
INNER JOIN `user` ON posts.user_id = user.id
INNER JOIN content_type ON posts.content_type_id = content_type.id
{$postNumberId};
SQL;

$resultNum = mysqli_query($link, $sqlPostNumber);
$postNums = mysqli_fetch_assoc($resultNum);



/* Создаем массив хэштегов для страницы поста*/
$sqlpostHash = <<<SQL
SELECT
posts.id,
hashtag.hashtag
FROM post_hashtags
INNER JOIN `posts` ON post_hashtags.post_id = posts.id
INNER JOIN `hashtag` ON post_hashtags.id = hashtag.id
{$postNumberId};
SQL;

$resultHush = mysqli_query($link, $sqlpostHash);
$postHashtags = mysqli_fetch_all($resultHush, MYSQLI_ASSOC);




/* Создаем массив количества постов у юзера для страницы поста */

$userWho = $postNums['user_id'];

$sqlPostSum = <<<SQL
SELECT
 COUNT(posts.id) as count_post_id,
 user.id as user_id
FROM posts
JOIN `user` ON posts.user_id = user.id
WHERE user.id = {$userWho};
SQL;

$resultPostSum = mysqli_query($link, $sqlPostSum);
$postPostSum = mysqli_fetch_assoc($resultPostSum);


/* Создаем массив количества комментариев для страницы поста */
$sqlCommentSum = <<<SQL
SELECT
COUNT(`comment`.`comment`) nember_comment,
posts.id post_id
FROM `comment`
INNER JOIN posts ON comment.post_id=posts.id
{$postNumberId};
SQL;
$resultCommentSum = mysqli_query($link, $sqlCommentSum);
$postCommentSum = mysqli_fetch_assoc($resultCommentSum);



/* Создаем массив количества подписчиков для страницы поста */
$sqlSubscrSum = <<<SQL
SELECT
subscription.author_id as author_id,
COUNT(subscription.person_subscripted_id) as sum_subscription
FROM `subscription`
JOIN `user` ON subscription.author_id = user.id
WHERE author_id={$userWho} GROUP BY author_id;
SQL;

$resultSubscrSum = mysqli_query($link, $sqlSubscrSum);
$postSubscrSum = mysqli_fetch_assoc($resultSubscrSum);


/* Создаем массив количества лайков для страницы поста */
$sqlLikeSum = <<<SQL
SELECT
COUNT(`like`.user_id) as like_sum,
posts.id as posts_id
FROM `like`
JOIN posts ON `like`.post_id=posts.id
{$postNumberId}
GROUP BY post_id;
SQL;

$resultLikeSum = mysqli_query($link, $sqlLikeSum);
$postLikeSum = mysqli_fetch_assoc($resultLikeSum);

/* Создаем массив количества репостов для страницы поста */
$sqlRepostSum = <<<SQL
SELECT
COUNT(repost.user_id) as repost_sum,
posts.id as post_id
FROM repost
JOIN posts ON repost.post_id=posts.id
{$postNumberId}
GROUP BY post_id;
SQL;

$resultRepostSum = mysqli_query($link, $sqlRepostSum);
$postRepostSum = mysqli_fetch_assoc($resultRepostSum);





/* Время когда юзер зарегистрировался на сайте */
$today = new DateTimeImmutable();
$userDateReg = new DateTime($postNums['created_at']);
$diffUserDateReg = $today->diff($userDateReg);

if ($diffUserDateReg->m >= 1) {
    $diffUserReg = sprintf('%d %s', $diffUserDateReg->m, get_noun_plural_form($diffUserDateReg->m, ' месяц ', ' месяца ', ' месяцев '));
}
elseif ($diffUserDateReg->days / 7 >= 1 && $diffUserDateReg->days / 7 < 5) {
    $weeks = floor($diffUserDateReg->days / 7);
    $diffUserReg = sprintf('%d %s', $weeks, get_noun_plural_form($weeks, ' неделя ', ' недели ', ' недель '));
}
elseif ($diffUserDateReg->days >= 1 && $diffUserDateReg->days < 7) {
    $diffUserReg = sprintf('%d %s', $diffUserDateReg->days, get_noun_plural_form($diffUserDateReg->d, ' день ', ' дня ', ' дней '));
}
elseif ($diffUserDateReg->h >= 1 && $diffUserDateReg->h < 24) {
    $diffUserReg = sprintf('%d %s', $diffUserDateReg->h, get_noun_plural_form($diffUserDateReg->h, ' час ', ' часа ', ' часов '));
}
elseif ($diffUserDateReg->i < 60) {
    $diffUserReg = sprintf('%d %s', $diffUserDateReg->i, get_noun_plural_form($diffUserDateReg->i, ' минута ', ' минуты ', ' минут '));
};


















function cutText($str, &$isCut, $length = 300)
{
    $isCut = false;

    if (mb_strlen($str) <= $length) {

        return $str;
    }

    $strArray = explode(' ', $str);
    $textLength = 0;

    foreach ($strArray as $index => $word) {
        $textLength += mb_strlen($word);
        if ($textLength >= $length){
            $isCut = true;

            return implode(" ", array_slice($strArray, 0, $index)) . '...';
        }
    }

    return null;
}

function esc($str) {
    $text = htmlspecialchars($str);

    return $text;
}


