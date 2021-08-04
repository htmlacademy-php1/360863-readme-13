<?php
require_once('helpers.php');
require_once('data.php');

$pageContent=include_template('main.php', ['posts' => $posts]);
$layoutContent=include_template('layout.php', [
    'title' => 'readme: популярное',
    'content' => $pageContent,
]);
echo ($layoutContent);
