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

$selectedContentType = $_POST['content_type'] ?? 'text';
$title = $_POST['title'] ?? null;
$hashtagString = $_POST['hashtag'] ?? null;
$imageUrl = $_POST['image_url'] ?? null; //http://somesite.com/img.png
$youtube = $_POST['youtube'] ?? null;
$text = $_POST['text'] ?? null;
$quoteAuthor = $_POST['quote_author'] ?? null;
$website = $_POST['website'] ?? null;
$errors = [];

if (!empty($_POST)) {
    $fileUploaded = false;
    if (!empty($_FILES['image']['name'])) {
        if (!in_array(mime_content_type($_FILES['image']['name']), ['image/gif', 'image/jpeg', 'image/png'])) {
            //ниже нужно заменить throw new на массив и вывести предупреждение в колонку справа $isMimeImg ?
            throw new Exception('Invalid file extension');
        }
        $fileObject = new SplFileInfo($_FILES['image']['name']);
        $filePath = 'imguploads/' . uniqid() . $fileObject->getExtension();

        //ниже нужно заменить throw new на массив и вывести предупреждение в колонку справа $isFileImg ?

        if (!move_uploaded_file($_FILES['image']['name'], $filePath)) {
            throw new Exception('An error occurred while uploading a file');
        }

        $imageUrl = $filePath; //imguploads/984uto83y4g983t.png
        $fileUploaded = true;
    }

    $rules = [
        'text' => [
            'title' =>  'Укажите заголовок поста',
            'text' => 'Укажите текст',
            'hashtag' => 'Укажите хэштеги'
        ],
        'quote' => [
            'title' => 'Укажите заголовок поста',
            'text' => 'Укажите текст цитаты',
            'quote_author' => 'Укажите автора цитаты',
            'hashtag' => 'Укажите хэштеги'
        ],
        'photo' => [
            'title' => 'Укажите заголовок поста',
            'image_url' => 'Укажите ссылку на изображение',
            'hashtag' => 'Укажите хэштеги'
        ],
        'video' => [
            'title' => 'Укажите заголовок поста',
            'youtube' => 'Укажите ссылку на Youtube',
            'hashtag' => 'Укажите хэштеги'
        ],
        'link' => [
            'title' => 'Укажите заголовок поста',
            'website' => 'Укажите ссылку на вебсайт',
            'hashtag' => 'Укажите хэштеги'
        ],
    ];

    foreach ($rules[$selectedContentType] as $field => $errorText) {
        if (empty($_POST[$field])) {
            $errors[$field] = $errorText;
        }
    }

    //другие проверки
    //проверяем правильный урл картинки из интернета??????????? или вставляем значение в $errorImageUrl
    if (
        $selectedContentType === 'photo'
        && !$fileUploaded &&
        !filter_var($imageUrl, FILTER_VALIDATE_URL)
    ) {
        $errors['image_url'] = 'File url is invalid';
    }

    //проверяем правильный урл ссылки на сайт из интернета??????????? или вставляем значение в $errorUrl
    if ($selectedContentType === 'link' && !filter_var($website, FILTER_VALIDATE_URL)) {
        $errors['website'] = 'неправильный url адрес сайта';
    }

    //проверяем правильный урл ссылки на ютуб??????????? или вставляем значение в $errorUrlYoutube
    if (
        $selectedContentType === 'video'
        && (!filter_var($website, FILTER_VALIDATE_URL) || !check_youtube_url($youtube))
    ) {
        $errors['youtube'] = 'неправильный url адрес видео на YouTube';
    }

    //ниже получаем id типа контента
    $contentTypeQuery = <<<SQL
SELECT id FROM content_type WHERE class = "{$selectedContentType}"
SQL;

    $resultContentTypeQuery = mysqli_query($link, $contentTypeQuery);
    $rowsContentTypeQuery = mysqli_fetch_assoc($resultContentTypeQuery);
    $contentTypeId = $rowsContentTypeQuery['id'];

//записываем пост в БД и получаем его id
    $sqlTemplates = [
        'text' => 'INSERT INTO posts (title, text, user_id, content_type_id) VALUES (?, ?, ?, ?)',
        'quote' => 'INSERT INTO posts (title, text, quote_author, user_id, content_type_id) VALUES (?, ?, ?, ?, ?)',
        'image' => 'INSERT INTO posts (title, image, user_id, content_type_id) VALUES (?, ?, ?, ?)',
        'youtube' => 'INSERT INTO posts (title, youtube, user_id, content_type_id) VALUES (?, ?, ?, ?)',
        'website' => 'INSERT INTO posts (title, website, user_id, content_type_id) VALUES (?, ?, ?, ?)',
    ];

    $lastPostId = null;

    if (empty($errors)) { //нужно дописать ошибки
        if ($selectedContentType === 'text') {
            $sqlNewPost = "INSERT INTO posts (title, text, user_id, content_type_id) VALUES ('{$_POST['title']}', '{$_POST['text']}', 1, {$contentTypeId})";
        } elseif ($selectedContentType === 'qoute') {
            $sqlNewPost = "INSERT INTO posts (title, text, quote_author, user_id, content_type_id) VALUES ('{$_POST['title']}', '{$_POST['text']}', '{$_POST['quote_author']}', 1, {$contentTypeId})";
        } elseif ($selectedContentType === 'image') {
            $sqlNewPost = "INSERT INTO posts (title, image, user_id, content_type_id) VALUES ('{$_POST['title']}', '{$_POST['image_url']}', 1, {$contentTypeId})";
        } elseif ($selectedContentType === 'youtube') {
            $sqlNewPost = "INSERT INTO posts (title, youtube, user_id, content_type_id) VALUES ('{$_POST['title']}', '{$_POST['youtube']}', 1, {$contentTypeId})";
        } elseif ($selectedContentType === 'website') {
            $sqlNewPost = "INSERT INTO posts (title, website, user_id, content_type_id) VALUES ('{$_POST['title']}', '{$_POST['website']}', 1, {$contentTypeId})";
        }
        mysqli_query($link, $sqlNewPost);
        $lastPostId = mysqli_insert_id($link); //получили id поста

        //записываем хэштеги в БД и получаем их id
        $hashtags = explode(' ', $hashtagString);
        foreach ($hashtags as $hashtag) {
            $hashTagSql = "SELECT * FROM hashtag WHERE hashtag = '{$hashtag}'";
            $result = mysqli_query($link, $hashTagSql);
            if (!$result) {
                $newHashTagSql = "INSERT INTO hashtag (hashtag) VALUES ('{$hashtag}')";
                $hashTagId = mysqli_insert_id($link);
            } else {
                $hashTagData = mysqli_fetch_assoc($result);
                $hashTagId = $hashTagData['id'];
            }

            //добавляем записи в таблицу post_hashtags
            $postHashTagSql = "INSERT INTO post_hashtags (post_id, hashtag_id) VALUES ({$lastPostId}, {$hashTagId})";
            $resultPostHashTag = mysqli_query($link, $postHashTagSql);
        }

        //при успешной отправке переадресовываем пользователя на новый пост?????????????????????????????
        if ($lastPostId) {
            header("Location: /post.php?id=$lastPostId");
            exit;
        } else {
            $errors[] = 'форма не отправлена';
        }
    }
}

$pageContent = include_template('adding-post.php', [
    'rowsContents' => $rowsContents,
    'selectedContentType' => $selectedContentType,
    'title' => $title,
    'hashtagString' => $hashtagString,
    'imageUrl' => $imageUrl,
    'youtube' => $youtube,
    'text' => $text,
    'quoteAuthor' => $quoteAuthor,
    'website' => $website,
    'errors' => $errors,
]);

echo include_template('layout.php', [
    'title' => 'readme: популярное',
    'content' => $pageContent,
    'userName' => $userName,
]);

} else {
    header('Location: /');

}
