<main class="page__main page__main--search-results">
    <h1 class="visually-hidden">Страница результатов поиска</h1>
    <section class="search">
        <h2 class="visually-hidden">Результаты поиска</h2>
        <div class="search__query-wrapper">
            <div class="search__query container">
                <span>Вы искали:</span>
                <span class="search__query-text"><?=$search; ?></span>
            </div>
        </div>
        <div class="search__results-wrapper">
            <div class="container">
                <div class="search__content">
    <?php foreach ($rowsSqlSearch as $index => $rowSqlSearch): ?>
        <?php $today = new DateTimeImmutable(); ?>
        <?php $postDate = new DateTime($rowSqlSearch['created_at']); ?>

                    <article class="search__post post post-<?=$rowSqlSearch['content_class']?>">
                        <header class="post__header post__author">
                            <a class="post__author-link" href="#" title="Автор">
                                <div class="post__avatar-wrapper">
                                    <img class="post__author-avatar" src="img/<?=$rowSqlSearch['user_avatar']; ?>" alt="Аватар пользователя" width="60" height="60">
                                </div>
                                <div class="post__info">
                                    <b class="post__author-name"><?=$rowSqlSearch['user_name']; ?></b>
                                    <span class="post__time">
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
                                    </span>
                                </div>
                            </a>
                        </header>
                        <div class="post__main">
                            <?php if($rowSqlSearch['content_class'] == "photo"): ?>
                            <h2><a href="#"><?=esc($rowSqlSearch['post_title']); ?></a></h2>
                            <div class="post-photo__image-wrapper">
                                <img src="img/<?=$rowSqlSearch['post_image']; ?>" alt="Фото от пользователя" width="760" height="396">
                            </div>

                            <?php elseif($rowSqlSearch['content_class'] == "text"): ?>
                            <h2><a href="#"><?=esc($rowSqlSearch['post_title']); ?></a></h2>
                            <p>
                                <?=cutText(esc($rowSqlSearch['post_text']), $wasTextCut, 300); ?>
                                <?php if ($wasTextCut) : ?>
                                    <a class="post-text__more-link" href="#">Читать далее</a>
                                <?php endif; ?>
                            </p>

                            <?php elseif($rowSqlSearch['content_class'] == "quote"): ?>
                                <blockquote>
                                    <p>
                                        <?=esc($rowSqlSearch['post_text']); ?>
                                    </p>
                                    <cite><?=esc($rowSqlSearch['post_quote_author']); ?></cite>
                                </blockquote>

                            <?php elseif($rowSqlSearch['content_class'] == "link"): ?>
                            <div class="post-link__wrapper">
                                <a class="post-link__external" href="<?=$rowSqlSearch['post_website']; ?>" title="Перейти по ссылке">
                                    <div class="post-link__icon-wrapper">
                                        <img src="img/logo-vita.jpg" alt="Иконка">
                                    </div>
                                    <div class="post-link__info">
                                        <h3><?=esc($rowSqlSearch['post_website_title']); ?></h3>
                                        <span><?=$rowSqlSearch['post_website']; ?></span>
                                    </div>
                                    <svg class="post-link__arrow" width="11" height="16">
                                        <use xlink:href="#icon-arrow-right-ad"></use>
                                    </svg>
                                </a>
                            </div>

                            <?php elseif($rowSqlSearch['content_class'] == "video"): ?>
                            <div class="post-video__block">
                                <div class="post-video__preview">
                                    <img src="img/coast.jpg" alt="Превью к видео" width="760" height="396">
                                </div>
                                <div class="post-video__control">
                                    <button class="post-video__play post-video__play--paused button button--video" type="button"><span class="visually-hidden">Запустить видео</span></button>
                                    <div class="post-video__scale-wrapper">
                                        <div class="post-video__scale">
                                            <div class="post-video__bar">
                                                <div class="post-video__toggle"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="post-video__fullscreen post-video__fullscreen--inactive button button--video" type="button"><span class="visually-hidden">Полноэкранный режим</span></button>
                                </div>
                                <button class="post-video__play-big button" type="button">
                                    <svg class="post-video__play-big-icon" width="27" height="28">
                                        <use xlink:href="#icon-video-play-big"></use>
                                    </svg>
                                    <span class="visually-hidden">Запустить проигрыватель</span>
                                </button>
                            </div>
                            <?php endif; ?>
                        </div>

                        <footer class="post__footer post__indicators">
                            <div class="post__buttons">
                                <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                    <svg class="post__indicator-icon" width="20" height="17">
                                        <use xlink:href="#icon-heart"></use>
                                    </svg>
                                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                        <use xlink:href="#icon-heart-active"></use>
                                    </svg>
                                    <span><?=$rowSqlSearch['likes_sum']; ?></span>
                                    <span class="visually-hidden">количество лайков</span>
                                </a>
                                <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                    <svg class="post__indicator-icon" width="19" height="17">
                                        <use xlink:href="#icon-comment"></use>
                                    </svg>
                                    <span><?=$rowSqlSearch['comments_sum']; ?></span>
                                    <span class="visually-hidden">количество комментариев</span>
                                </a>
                            </div>
                        </footer>
                    </article>
    <?php endforeach; ?>

            </div>
        </div>
    </section>
</main>
