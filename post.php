<?php
/**
 * @var bool $isAuth
 */

require_once('helpers.php');
require_once('link.php');

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
    hashtag.hashtag
FROM posts
JOIN post_hashtags ON post_hashtags.post_id = posts.id
JOIN hashtag ON hashtag.id = post_hashtags.hashtag_id
{$postNumberId}
;
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
{$postNumberId}
GROUP BY post_id;
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

if (isset($_SESSION['user'])) {


if (!isset($_GET['id']) || empty($postNums)) {
    http_response_code(404);
    $pageContent = 'такой страницы нет';
} else {
    $pageContent = include_template('post-details.php', [
        'postNums' => $postNums,
        'postHashtags' => $postHashtags,
        'postPostSum' => $postPostSum,
        'diffUserReg' => $diffUserReg,
        'postCommentSum' => $postCommentSum,
        'postSubscrSum' => $postSubscrSum,
        'postLikeSum' => $postLikeSum,
        'postRepostSum' => $postRepostSum,
    ]);
}

echo include_template('layout.php', [
    'title' => 'readme: популярное',
    'content' => $pageContent,
]);

} else {
    header('Location: /');

}

