<?php

//что то с загрузкой фотографий
//почему то функция password_verify() не хочет работать


/**
 * @var bool $isAuth
 * @var string $userName
 */

require_once('helpers.php');
require_once('data.php');

$_SESSION = [];

$loginMain = $_POST['login'] ?? null;
$passwordMain = $_POST['password'] ?? null;
$errors = [];

$errorLogin = ''; /*'<span class="form__error-label form__error-label--login">Неверный логин</span>';*/
$errorPassword = ''; /*'<span class="form__error-label">Пароли не совпадают</span>';*/
$errorLoginClass = '';    /*form__input-section--error*/
$errorPasswordClass = '';

if (!empty($_POST)) {

    $sqlMainUser = <<<SQL
SELECT *
FROM user
WHERE login = '{$_POST['login']}';
SQL;

    $resultSqlMainUser = mysqli_query($link, $sqlMainUser);
    $rowsSqlMainUser = mysqli_fetch_assoc($resultSqlMainUser);

    if (empty($_POST['login'])) {
        $errorLogin = '<span class="form__error-label form__error-label--login">Заполните поле логин</span>';
        $errorLoginClass = 'form__input-section--error';
    }

    if (!empty($_POST['login']) && $rowsSqlMainUser['login'] !==  $_POST['login']) {
        $errorLogin = '<span class="form__error-label form__error-label--login">Неверный логин</span>';
        $errorLoginClass = 'form__input-section--error';
    }

    if (empty($_POST['password'])) {
        $errorPassword = '<span class="form__error-label">Заполните поле пароль</span>';
        $errorPasswordClass = 'form__input-section--error';
    }

    if (!empty($_POST['password']) && $rowsSqlMainUser['password'] !==  $_POST['password']) {
        $errorPassword = '<span class="form__error-label">Пароли не совпадают</span>';
        $errorPasswordClass = 'form__input-section--error';
    }


/*    var_dump(md5($_POST['password']));
    var_dump($rowsSqlMainUser['password']);
    var_dump(password_verify('$_POST[\'password\']', '$rowsSqlMainUser[\'password\']'));*/


    if ($rowsSqlMainUser['login'] ===  $_POST['login']
        && md5($_POST['password']) === $rowsSqlMainUser['password'] /*password_verify($_POST['password'], $rowsSqlMainUser['password'])*/) {
        $_SESSION['user'] = $rowsSqlMainUser;
        var_dump($_SESSION['user']);
        header("Location: http://360863-readme-13/feed.php");
        exit;
}

}

echo include_template('main.php', [
    'loginMain' => $loginMain,
    'passwordMain' => $passwordMain,
    'errorLogin' => $errorLogin,
    'errorPassword' => $errorPassword,
    'errorLoginClass' => $errorLoginClass,
    'errorPasswordClass' => $errorPasswordClass,

]);

