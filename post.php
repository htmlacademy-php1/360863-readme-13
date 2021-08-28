<?php
/**
 * @var bool $isAuth
 * @var string $userName
 */

require_once('helpers.php');
require_once('data.php');

/*echo '<pre>';
print_r($postRepostSum);
die();*/

if (!isset($_GET['id']) OR empty($postNums)) {
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

$layoutContent = include_template('layout.php', [
    'title' => 'readme: популярное',
    'content' => $pageContent,
    'isAuth' => $isAuth,
    'userName' => $userName,
]);


echo $layoutContent;
