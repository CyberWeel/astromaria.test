<? get_header();
yoast_breadcrumb('<div class="breadcrumbs">', '</div>');

while (have_posts()) {
  the_post();

  $categories = get_the_category();
  $category_name = !empty($categories) ? $categories[0]->name : '';
  $content = apply_filters('the_content', get_the_content());
  $content_length = mb_strlen(strip_tags($content));
  $date = get_the_date('j F Y');
  $image = get_the_post_thumbnail_url();
  $tags = [];
  $tags_raw = get_the_tags();
  $views = get_post_views();
  $views_word = '';
  $time = max(1, (int) ceil($content_length / 1000)); # 1000 - средняя скорость чтения в символах/минуту взрослым человеком
  $time_word = '';
  $title = get_the_title();
  $article_related = get_related_posts('news');

  if ($tags_raw) {
    foreach ($tags_raw as $tag) {
      $tags[] = $tag->name;
    }
  }
  
  if ($time % 100 >= 11 && $time % 100 <= 14)   $time_word = 'минут';
  elseif ($time % 10 === 1)                     $time_word = 'минута';
  elseif ($time % 10 >= 2 && $time % 10 <= 4)   $time_word = 'минуты';
  else                                          $time_word = 'минут';

  if ($views % 100 >= 11 && $views % 100 <= 14) $views_word = 'просмотров';
  elseif ($views % 10 === 1)                    $views_word = 'просмотр';
  elseif ($views % 10 >= 2 && $views % 10 <= 4) $views_word = 'просмотра';
  else                                          $views_word = 'просмотров';
  ?>
  <article class="article">
    <? if ($category_name) { ?>
      <div class="article__category"><?=esc_html($category_name)?></div>
    <? } ?>
    <h1 class="article__name"><?=esc_html($title)?></h1>
    <div class="article__information">
      <div class="article__date">
        <div class="article__date-icon"></div>
        <div class="article__date-content"><?=$date?></div>
      </div>
      <div class="article__views">
        <div class="article__views-icon"></div>
        <div class="article__views-content"><?=$views?> <?=$views_word?></div>
      </div>
      <div class="article__reading">
        <div class="article__reading-icon"></div>
        <div class="article__reading-content"><?=$time?> <?=$time_word?> чтения</div>
      </div>
    </div>
    <? if (!empty($image)) { ?>
      <div class="article__image" style="background-image: url('<?=$image?>');"></div>
    <? } ?>
    <div class="article__content"><?=$content?></div>
    <hr class="article__line">
    <div class="article__socials">
      <div class="article__socials-text">Поделиться:</div>
      <div class="article__socials-list">
        <div class="article__socials-item">
          <a class="article__socials-link article__socials-link--vk" href="https://vk.ru/astromaria_assistant" target="_blank"></a>
        </div>
      </div>
    </div>
    <? if ($tags) { ?>
      <div class="article__tags">
        <div class="article__tags-text">Теги:</div>
        <div class="article__tags-list">
          <? foreach ($tags as $tag) { ?>
            <div class="article__tags-item"><?=esc_html($tag)?></div>
          <? } ?>
        </div>
      </div><?
    }

    if ($article_related) { ?>
      <section class="articles">
        <div class="articles__header">
          <h2 class="articles__heading">Похожие новости</h2>
        </div>
        <div class="articles__content">
          <? foreach ($article_related as $article_related_id) { ?>
            <a class="articles__item" href="<?=esc_url(get_permalink($article_related_id))?>">
              <div class="articles__image" style="background-image: url('<?=get_the_post_thumbnail_url($article_related_id)?>');"></div>
              <div class="articles__item-content">
                <div class="articles__name"><?=esc_html(get_the_title($article_related_id))?></div>
                <div class="articles__date-footer">
                  <div class="articles__date-footer-icon"></div>
                  <div class="articles__date-footer-content"><?=get_the_date('j F Y', $article_related_id)?></div>
                </div>
              </div>
            </a>
          <? } ?>
        </div>
      </section>
    <? } ?>
  </article><?
}

get_footer() ?>