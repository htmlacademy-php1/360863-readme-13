
<?php
/**
 * @var bool $isAuth
 * @var string $userName
 * @var array $rows
 * @var array $rowsContents
 */


require_once('helpers.php');
require_once('data.php');

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
        'userName' => $userName,


    ]);
} else {
    header('Location: /');

}
