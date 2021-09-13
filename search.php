<?php

/**
 * @var bool $isAuth
 */

require_once('helpers.php');
require_once('link.php');

if (!isset($_SESSION['user'])) {
    header('Location: /');
}

if (!isset($_GET['search']) || !trim($_GET['search'])) {
    throw new Exception('Page not found', 404);
}

$search = mysqli_real_escape_string($link, $_GET['search']);

$sqlSearch = <<<SQL
SELECT
    posts.created_at,
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
    content_type.class content_class,
    COUNT(comment.id) comments_sum,
    COUNT(`like`.id) likes_sum
FROM posts
INNER JOIN `user` ON posts.user_id = user.id
INNER JOIN content_type ON posts.content_type_id = content_type.id
LEFT JOIN post_hashtags ON post_hashtags.post_id = posts.id
LEFT JOIN hashtag ON hashtag.id = post_hashtags.hashtag_id
LEFT JOIN comment ON comment.post_id = posts.id
LEFT JOIN `like` ON `like`.post_id = posts.id
WHERE MATCH(posts.title, posts.text) AGAINST('{$search}' IN BOOLEAN MODE)
OR MATCH(hashtag.hashtag) AGAINST('{$search}')
GROUP BY posts.id
SQL;

$resultSqlSearch = mysqli_query($link, $sqlSearch);
$rowsSqlSearch = mysqli_fetch_all($resultSqlSearch, MYSQLI_ASSOC);
if (mysqli_error($link)) {
    throw new Exception(mysqli_error($link), 500);
}


echo include_template('layout.php', [
    'title' => 'readme: популярное',
    'content' => include_template(empty($rowsSqlSearch) ? 'no-results.php' : 'search-results.php', [
        'search' => $search,
        'rowsSqlSearch' => $rowsSqlSearch,
    ]),
]);
