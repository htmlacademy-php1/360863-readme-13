<!--Ошибки:
1. Загружает вместо изображения любой файл
5. Как определить условие, что если пользователь находится на конкретной странице, то ему не показывать что-то из html кода
-->



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

$email = $_POST['email'] ?? null;
$login = $_POST['login'] ?? null;
$password = $_POST['password'] ?? null;
$passwordRepeat = $_POST['password-repeat'] ?? null;

$rules = [
    'email' => 'заполните поле email',
    'login' => 'заполните поле логин',
    'password' => 'придумайте пароль',
    'password-repeat' => 'повторите пароль',
];

$regErrors = [];
$imageUrl = null;

if (!empty($_POST)) {

//проверка загрузки аватара
    if (!empty($_FILES['image']['name'])) {
        if (!in_array(mime_content_type($_FILES['image']['name']), ['image/gif', 'image/jpeg', 'image/png'])) {
            throw new Exception('Invalid file extension');
        }
        $fileObject = new SplFileInfo($_FILES['image']['name']);
        $filePath = 'imguploads/' . uniqid() . $fileObject->getExtension();

        if (!move_uploaded_file($_FILES['image']['name'], $filePath)) {
            throw new Exception('An error occurred while uploading a file');
        }

        $imageUrl = $filePath;

    }

//валидация email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $regErrors['email'] = 'не корректно указан email';
    }

//проверяем совпадение паролей
    if ($_POST['password'] !== $_POST['password-repeat']) {
        $regErrors['password-repeat'] = 'пароли должны совпадать';
    }

//проверяем совпадение email
    $sqlUserEmail = <<<SQL
SELECT
email
FROM user
WHERE email = '{$_POST['email']}';
SQL;

    $resultUserEmail = mysqli_query($link, $sqlUserEmail);

    if (mysqli_num_rows($resultUserEmail)) {
        $regErrors['email'] = 'такой email уже зарагистрирован';
    }

//проверка заполненности остальных полей
    foreach ($rules as $field => $errorText) {
        if (empty($_POST[$field])) {
            $regErrors[$field] = $errorText;
        }
    }

//записываем юзера в бд


    if (empty($regErrors)) {
        $hashPassword = md5($password);
        $sqlNewUser = <<<SQL
INSERT INTO user (login, email, password, avatar)
VALUES ('{$_POST['login']}', '{$_POST['email']}', '{$hashPassword}', '{$imageUrl}');
SQL;
        $resultSqlNewUser = mysqli_query($link, $sqlNewUser);

var_dump(mysqli_error($link));

        $lastUserId = mysqli_insert_id($link);



//eсли юзер создался переадресовываем на главную страницу
        if ($lastUserId) {
            header("Location: /index.php");
            exit;
        } else {
            $regErrors[] = 'форма не отправлена';
        }
    }

}



$pageContent = include_template('registration.php', [
    'email' => $email,
    'login' => $login,
    'password' => $password,
    'passwordRepeat' => $passwordRepeat,
    'regErrors' => $regErrors,


]);

echo include_template('layout.php', [
    'title' => 'readme: популярное',
    'content' => $pageContent,
    'userName' => $userName,

]);
