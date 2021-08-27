<?php
/**
 * @var bool $isAuth
 * @var string $userName
 * @var string $title
 * @var string $content
 * @var array $rows
 * @var array $rowsContents
 * @var bool $wasTextCut * это вот значение же bool правильно?
 */
?>

<div class="container">
    <h1 class="page__title page__title--popular">Популярное</h1>
</div>
<div class="popular container">
    <div class="popular__filters-wrapper">
        <div class="popular__sorting sorting">
            <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
            <ul class="popular__sorting-list sorting__list">
                <li class="sorting__item sorting__item--popular">
                    <a class="sorting__link sorting__link--active" href="<?=$urlSort; ?>">
                        <span>Популярность</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
                <li class="sorting__item">
                    <a class="sorting__link" href="#">
                        <span>Лайки</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
                <li class="sorting__item">
                    <a class="sorting__link" href="#">
                        <span>Дата</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
        <div class="popular__filters filters">
            <b class="popular__filters-caption filters__caption">Тип контента:</b>
            <ul class="popular__filters-list filters__list">
                    <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                        <a class="filters__button filters__button--ellipse filters__button--all <?=$selectedContentType ? '' : 'filters__button--active'; ?>" href="/">
                            <span>Все</span>
                        </a>
                    </li>
                    <?php foreach ($rowsContents as $rowsContent): ?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--photo button <?=$selectedContentType == $rowsContent['id'] ? 'filters__button--active': '';?> " href="<?='index.php?class=' . $rowsContent['id'];?> ">
<!--                            --><?php /*if ($selectedContentType == $rowsContent['id']) {
                                echo 'filters__button--active';
                            }
                            else {
                                echo '';
                            }
                            */?>
                            <span class="visually-hidden"><?=$rowsContent['name'];?></span>
                            <svg class="filters__icon" width="22" height="18">
                                <use xlink:href="#icon-filter-<?=$rowsContent['class'];?>"></use>
                            </svg>
                        </a>
                    </li>
                    <?php endforeach; ?>
            </ul>
        </div>
    </div>



    <div class="popular__posts">

        <?php foreach ($rows as $index => $row): ?>
            <?php $today = new DateTimeImmutable(); ?>
            <?php $postDate = new DateTime(generate_random_date ($index)); ?>
            <article class="popular__post post post-<?=$row['content_class'];?>">
                <header class="post__header">
                    <h2><a href="/post.php?id=<?=$row['id']; ?>"><?=esc($row['post_title']);?><!--здесь заголовок--></a></h2>
                </header>

                <div class="post__main"><!--здесь содержимое карточки-->
                    <?php if($row['content_class'] == "quote"): ?>
                        <blockquote>
                            <p>
                                <?=esc($row['post_text']); ?><!--здесь текст-->
                            </p>
                            <cite><?=esc($row['post_quote_author']); ?></cite><!--здесь Автор цитаты-->
                        </blockquote>

                    <?php elseif($row['content_class'] == "text"): ?>
                        <p>
                            <?=cutText(esc($row['post_text']), $wasTextCut, 300); ?>
                            <?php if ($wasTextCut) : ?>
                                <a class="post-text__more-link" href="#">Читать далее</a>
                            <?php endif; ?>
                        </p>

                    <?php elseif($row['content_class'] == "photo"): ?>
                        <div class="post-photo__image-wrapper">
                            <img src="img/<?=$row['post_image']; ?>" alt="Фото от пользователя" width="360" height="240">
                        </div>

                    <?php elseif($row['content_class'] == "link"): ?>
                        <div class="post-link__wrapper">
                            <a class="post-link__external" href="http://" title="Перейти по ссылке">
                                <div class="post-link__info-wrapper">
                                    <div class="post-link__icon-wrapper">
                                        <img src="https://www.google.com/s2/favicons?domain=vitadental.ru" alt="Иконка">
                                    </div>
                                    <div class="post-link__info">
                                        <h3><?=esc($row['post_website_title']); ?><!--здесь заголовок--></h3>
                                    </div>
                                </div>
                                <span><?=$row['post_website']; ?><!--здесь ссылка/а вот не понятно нужно функцию накладывать на ссылку?--></span>
                            </a>
                        </div>
                    <?php endif; ?>

                </div>
                <footer class="post__footer">
                    <div class="post__author">
                        <a class="post__author-link" href="#" title="<?=date_format($postDate, "d-m-Y H:i") ?>">
                            <div class="post__avatar-wrapper">
                                <!--укажите путь к файлу аватара-->
                                <img class="post__author-avatar" src="img/<?=$row['user_avatar'];?>" alt="Аватар пользователя">
                            </div>
                            <div class="post__info">
                                <b class="post__author-name"><?=esc($row['user_name']);?><!--здесь имя пользоателя--></b>
                                <time class="post__time" datetime=" ">

                                        <?php $diff = $today->diff($postDate); ?>

                                        <?php if ($diff->m >= 1): ?>
                                            <?php $diffString = sprintf('%d %s', $diff->m, get_noun_plural_form($diff->m, ' месяц назад', ' месяца назад', ' месяцев назад')); ?>
                                        <?php elseif ($diff->days / 7 >= 1 && $diff->days / 7 < 5): ?>
                                            <?php $weeks = floor($diff->days / 7); ?>
                                            <?php $diffString = sprintf('%d %s', $weeks, get_noun_plural_form($weeks, ' неделя назад', ' недели назад', ' недель назад')); ?>
                                        <?php elseif ($diff->days >= 1 && $diff->days < 7): ?>
                                            <?php $diffString = sprintf('%d %s', $diff->days, get_noun_plural_form($diff->d, ' день назад', ' дня назад', ' дней назад')); ?>
                                        <?php elseif ($diff->h >= 1 && $diff->h < 24): ?>
                                            <?php $diffString = sprintf('%d %s', $diff->h, get_noun_plural_form($diff->h, ' час назад', ' часа назад', ' часов назад')); ?>
                                        <?php elseif ($diff->i < 60): ?>
                                            <?php $diffString = sprintf('%d %s', $diff->i, get_noun_plural_form($diff->i, ' минута назад', ' минуты назад', ' минут назад')); ?>
                                        <?php endif; ?>

                                        <?=$diffString; ?>

                                </time><!--здесь дата поста-->
                            </div>
                        </a>
                    </div>
                    <div class="post__indicators">
                        <div class="post__buttons">
                            <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                <svg class="post__indicator-icon" width="20" height="17">
                                    <use xlink:href="#icon-heart"></use>
                                </svg>
                                <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                    <use xlink:href="#icon-heart-active"></use>
                                </svg>
                                <span>0</span>
                                <span class="visually-hidden">количество лайков</span>
                            </a>
                            <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                <svg class="post__indicator-icon" width="19" height="17">
                                    <use xlink:href="#icon-comment"></use>
                                </svg>
                                <span>0</span>
                                <span class="visually-hidden">количество комментариев</span>
                            </a>
                        </div>
                    </div>
                </footer>
            </article>
        <?php endforeach; ?>
    </div>
</div>
