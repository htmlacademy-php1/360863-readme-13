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

$sqlPost = <<<SQL
SELECT
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
ORDER BY views DESC;
SQL;

$resultPost = mysqli_query($link, $sqlPost);
$rows = mysqli_fetch_all($resultPost, MYSQLI_ASSOC);


$sqlContentType = <<<SQL
SELECT *
FROM content_type
SQL;

$resultContentType = mysqli_query($link, $sqlContentType);
$rowsContents = mysqli_fetch_all($resultContentType, MYSQLI_ASSOC);



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


