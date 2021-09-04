
<?php
/**
 * @var bool $isAuth
 * @var string $userName
 * @var array $rows
 * @var array $rowsContents
 */

require_once('helpers.php');
require_once('data.php');

/*echo '<pre>';
print_r($rowsContents);
die();*/

$pageContent = include_template('main.php', [
    'rows' => $rows,
    'rowsContents' => $rowsContents,
    'paramsIndex' => $paramsIndex,
    'urlSort' => $urlSort,
    'selectedContentType' => $_GET['class'] ?? null,


]);

$layoutContent = include_template('layout.php', [
    'title' => 'readme: популярное',
    'content' => $pageContent,
    'isAuth' => $isAuth,
    'userName' => $userName,
]);
echo $layoutContent;
