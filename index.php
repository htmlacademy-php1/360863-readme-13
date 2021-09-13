<?php

/**
 * @var bool $isAuth
 */

require_once('helpers.php');
require_once('link.php');

$_SESSION = [];

$loginMain = $_POST['login'] ?? null;
$errors = [];

if (!empty($_POST)) {

    if (!empty($_POST['login']) && !empty($_POST['password'])) {

        $login = mysqli_real_escape_string($link, $_POST['login']);
        $password = mysqli_real_escape_string($link, $_POST['password']);

        $sqlMainUser = <<<SQL
SELECT *
FROM user
WHERE login = '{$login}' AND password = MD5('{$password}');
SQL;


        $resultSqlMainUser = mysqli_query($link, $sqlMainUser);
        $rowsSqlMainUser = mysqli_fetch_assoc($resultSqlMainUser);

        /*var_dump($resultSqlMainUser);*/
        if (!$rowsSqlMainUser) {
            $errors['login'] = 'логин / пароль не верны';
        } else {
            $_SESSION['user'] = $rowsSqlMainUser;
            header("Location: /feed.php");
            exit;
        }
    } else {
        if (empty($_POST['login'])) {
            $errors['login'] = 'введите логин';
        }
        if (empty($_POST['password'])) {
            $errors['password'] = 'введите пароль';
        }

    }

}
echo include_template('main.php', [
    'loginMain' => $loginMain,
    'errors' => $errors,

]);

