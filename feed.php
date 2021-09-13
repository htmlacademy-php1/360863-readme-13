
<?php
/**
 * @var bool $isAuth
 * @var array $rows
 * @var array $rowsContents
 */

require_once('helpers.php');
require_once('link.php');

if (isset($_SESSION['user'])) {

    $pageContent = include_template('lenta.php', [

        ]);

    echo include_template('layout.php', [
        'title' => 'readme: популярное',
        'content' => $pageContent,

        ]);

} else {
        header('Location: /');

}
