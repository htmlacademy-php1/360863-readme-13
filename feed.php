
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

    $pageContent = include_template('lenta.php', [

        ]);

    echo include_template('layout.php', [
        'title' => 'readme: популярное',
        'content' => $pageContent,
        'userName' => $userName,

        ]);

} else {
        header('Location: http://360863-readme-13/');

}
