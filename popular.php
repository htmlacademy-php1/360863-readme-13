
<?php
/**
 * @var bool $isAuth
 * @var array $rows
 * @var array $rowsContents
 */


require_once('helpers.php');
require_once('link.php');

$contentTypeCondition = isset($_GET['class'])
    ? "WHERE posts.content_type_id = {$_GET['class']}" : '';

$sortDirection = $_GET['sort'] ?? 'ASC';


$sqlPost = <<<SQL
SELECT
       posts.id,
       posts.created_at,
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

$paramsIndex = $_GET;
$paramsIndex['sort'] = $sortDirection == 'ASC' ? 'DESC' : 'ASC';
$urlQueryIndex = http_build_query($paramsIndex);
$urlSort = "/" . 'popular.php' . "?" . $urlQueryIndex;

$sqlContentType = <<<SQL
SELECT *
FROM content_type
SQL;

$resultContentType = mysqli_query($link, $sqlContentType);
$rowsContents = mysqli_fetch_all($resultContentType, MYSQLI_ASSOC);

if (isset($_SESSION['user'])) {

    $pageContent = include_template('popular-posts.php', [
        'rows' => $rows,
        'rowsContents' => $rowsContents,
        'paramsIndex' => $paramsIndex,
        'urlSort' => $urlSort,
        'selectedContentType' => $_GET['class'] ?? null,

    ]);

    echo include_template('layout.php', [
        'title' => 'readme: популярное',
        'content' => $pageContent,


    ]);
} else {
    header('Location: /');

}
