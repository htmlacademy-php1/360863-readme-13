<?php
/**
 * @var bool $isAuth
 * @var string $userName
 * @var string $title
 * @var string $content
 * @var array $rows
 * @var array $rowsContents
 * @var string[] $errors
 */

?>
<main class="page__main page__main--adding-post">
    <div class="page__main-section">
        <div class="container">
            <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
            <div class="adding-post__tabs-wrapper tabs">
                <div class="adding-post__tabs filters">
                    <ul class="adding-post__tabs-list filters__list tabs__list">
                        <?php foreach ($rowsContents as $rowsContent): ?>
                            <li class="adding-post__tabs-item filters__item">
                                <a class="adding-post__tabs-link filters__button filters__button--<?=$rowsContent['class']; ?> <?= $selectedContentType == $rowsContent['class'] ? 'filters__button--active' : ''; ?> tabs__item button">
                                    <svg class="filters__icon" width="22" height="18">
                                        <use xlink:href="#icon-filter-<?=$rowsContent['class']; ?>"></use>
                                    </svg>
                                    <span><?=$rowsContent['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="adding-post__tab-content">
                    <section class="adding-post__text tabs__content tabs__content--active">
                        <h2 class="visually-hidden">Форма добавления текста</h2>
                        <form class="adding-post__form form" action="add.php" method="post">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="text-heading">Заголовок <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['title']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="text-heading" type="text" value="<?=$title; ?>" name="title" placeholder="Введите заголовок">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adding-post__textarea-wrapper form__textarea-wrapper">
                                        <label class="adding-post__label form__label" for="post-text">Текст поста <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['text']) ? 'form__input-section--error' : ''; ?>">
                                            <textarea class="adding-post__textarea form__textarea form__input" name="text" id="post-text" placeholder="Введите текст публикации"><?= $text; ?></textarea>
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="post-tags">Теги</label>
                                        <div class="form__input-section <?= isset($errors['hashtag']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="post-tags" type="text" value="<?=$hashtagString; ?>" name="hashtag" placeholder="Введите теги">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form__invalid-block">
                                    <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                                    <ul class="form__invalid-list">
                                        <?php foreach ($errors as $error): ?>
                                            <li class="form__invalid-item"><?= $error; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                                <a class="adding-post__close" href="#">Закрыть</a>
                            </div>
                            <input type="hidden" name="content_type" value="text" />
                        </form>
                    </section>

                    <section class="adding-post__quote tabs__content">
                        <h2 class="visually-hidden">Форма добавления цитаты</h2>
                        <form class="adding-post__form form" action="add.php" method="post">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="quote-heading">Заголовок <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['title']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="quote-heading" type="text" value="<?=$title; ?>" name="title" placeholder="Введите заголовок">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adding-post__input-wrapper form__textarea-wrapper">
                                        <label class="adding-post__label form__label" for="cite-text">Текст цитаты <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['text']) ? 'form__input-section--error' : ''; ?>">
                                            <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input" name="text" id="cite-text" placeholder="Текст цитаты"><?= $text; ?></textarea>
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adding-post__textarea-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['quote_author']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="quote-author" type="text" value="<?=$quoteAuthor; ?>" name="quote_author">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="cite-tags">Теги</label>
                                        <div class="form__input-section <?= isset($errors['hashtag']) ? 'form__input-section--error' : ''; ?>">>
                                            <input class="adding-post__input form__input" id="cite-tags" type="text" value="<?=$hashtagString; ?>" name="hashtag" placeholder="Введите теги">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form__invalid-block">
                                    <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                                    <ul class="form__invalid-list">
                                        <?php foreach ($errors as $error): ?>
                                            <li class="form__invalid-item"><?=$error?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                                <a class="adding-post__close" href="#">Закрыть</a>
                            </div>
                            <input type="hidden" name="content_type" value="quote" />
                        </form>
                    </section>

                    <section class="adding-post__photo tabs__content">
                        <h2 class="visually-hidden">Форма добавления фото</h2>
                        <form class="adding-post__form form" action="add.php" method="post" enctype="multipart/form-data">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="photo-heading">Заголовок <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['title']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="photo-heading" type="text" value="<?=$title; ?>" name="title" placeholder="Введите заголовок">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
                                        <div class="form__input-section <?= isset($errors['image_url']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="photo-url" type="text" value="<?=$imageUrl; ?>" name="image_url" placeholder="Введите ссылку">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="photo-tags">Теги</label>
                                        <div class="form__input-section <?= isset($errors['hashtag']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="photo-tags" type="text" value="<?=$hashtagString; ?>" name="hashtag" placeholder="Введите теги">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form__invalid-block">
                                    <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                                    <ul class="form__invalid-list">
                                        <?php foreach ($errors as $error): ?>
                                            <li class="form__invalid-item"><?=$error?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="adding-post__input-file-container form__input-container form__input-container--file">
                                <div class="adding-post__input-file-wrapper form__input-file-wrapper">
                                    <div class="adding-post__file-zone adding-post__file-zone--photo form__file-zone dropzone">
                                        <input class="adding-post__input-file form__input-file" id="userpic-file-photo" type="file" name="image" />
                                        <div class="form__file-zone-text">
                                            <span>Перетащите фото сюда</span>
                                        </div>
                                    </div>
                                    <button class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button" type="button">
                                        <span>Выбрать фото</span>
                                        <svg class="adding-post__attach-icon form__attach-icon" width="10" height="20">
                                            <use xlink:href="#icon-attach"></use>
                                        </svg>
                                    </button>
                                </div>
                                <div class="adding-post__file adding-post__file--photo form__file dropzone-previews">

                                </div>
                            </div>
                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                                <a class="adding-post__close" href="#">Закрыть</a>
                            </div>
                            <input type="hidden" name="content_type" value="photo" />
                        </form>
                    </section>

                    <section class="adding-post__video tabs__content">
                        <h2 class="visually-hidden">Форма добавления видео</h2>
                        <form class="adding-post__form form" action="add.php" method="post" enctype="multipart/form-data">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="video-heading">Заголовок <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['title']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="video-heading" type="text" value="<?=$title; ?>" name="title" placeholder="Введите заголовок">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="video-url">Ссылка youtube <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['youtube']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="video-url" type="text" value="<?=$youtube; ?>" name="youtube" placeholder="Введите ссылку">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="video-tags">Теги</label>
                                        <div class="form__input-section <?= isset($errors['hashtag']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="video-tags" type="text" value="<?=$hashtagString; ?>" name="hashtag" placeholder="Введите тэги">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form__invalid-block">
                                    <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                                    <ul class="form__invalid-list">
                                        <?php foreach ($errors as $error): ?>
                                            <li class="form__invalid-item"><?=$error?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>

                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                                <a class="adding-post__close" href="#">Закрыть</a>
                            </div>
                            <input type="hidden" name="content_type" value="video" />
                        </form>
                    </section>

                    <section class="adding-post__link tabs__content">
                        <h2 class="visually-hidden">Форма добавления ссылки</h2>
                        <form class="adding-post__form form" action="add.php" method="post">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="link-heading">Заголовок <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['title']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="link-heading" type="text" value="<?=$title; ?>" name="title" placeholder="Введите заголовок">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adding-post__textarea-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="post-link">Ссылка <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['website']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="post-link" type="text" value="<?=$website; ?>" name="website">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="link-tags">Теги</label>
                                        <div class="form__input-section <?= isset($errors['hashtag']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="link-tags" type="text" value="<?=$hashtagString; ?>" name="hashtag" placeholder="Введите ссылку">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form__invalid-block">
                                    <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                                    <ul class="form__invalid-list">
                                        <?php foreach ($errors as $error): ?>
                                            <li class="form__invalid-item"><?=$error?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                                <a class="adding-post__close" href="#">Закрыть</a>
                            </div>
                            <input type="hidden" name="content_type" value="link" />
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</main>
