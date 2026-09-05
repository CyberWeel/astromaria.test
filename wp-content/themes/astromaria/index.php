<? get_header();
global $post;

$last_news = get_posts(['post_type' => 'news', 'posts_per_page' => 4]);
$last_articles = get_posts(['posts_per_page' => 4]);
?>
<section class="banner">
  <div class="banner__content">
    <h1 class="banner__heading">Откройте Вселенную вместе с <span class="banner__heading-colored">AstroMaria</span></h1>
    <div class="banner__description">Научно-популярные материалы об астрономии, космосе и последних открытиях.</div>
    <a class="banner__button" href="/articles/">Читать статьи <span>&#8594</span></a>
  </div>
</section>
<section class="last-news">
  <div class="last-news__header">
    <h2 class="last-news__heading">Последние новости</h2>
    <a class="last-news__header-link" href="/news/">Смотреть все новости &#8594</a>
  </div>
  <div class="last-news__content"><?
    foreach ($last_news as $last_news_item) {
      setup_postdata($post); ?>
      <a class="last-news__item" href="<?=get_permalink($last_news_item->ID)?>">
        <div class="last-news__image" style="background-image: url('<?=get_the_post_thumbnail_url($last_news_item->ID)?>');"></div>
        <div class="last-news__item-content">
          <div class="last-news__date"><?=wp_date('j F Y', strtotime($last_news_item->post_date))?></div>
          <div class="last-news__name"><?=$last_news_item->post_title?></div>
          <div class="last-news__description"><?=show_custom_excerpt($last_news_item->post_content)?></div>
        </div>
      </a><?
    }
    
    wp_reset_postdata(); ?>
  </div>
</section>
<section class="last-articles">
  <div class="last-articles__header">
    <h2 class="last-articles__heading">Популярные статьи</h2>
    <a class="last-articles__header-link" href="/articles/">Смотреть все статьи &#8594</a>
  </div>
  <div class="last-articles__content"><?
    foreach ($last_articles as $last_articles_item) {
      setup_postdata($post); ?>
      <a class="last-articles__item" href="<?=get_permalink($last_articles_item->ID)?>">
        <div class="last-articles__image" style="background-image: url('<?=get_the_post_thumbnail_url($last_articles_item->ID)?>');"></div>
        <div class="last-articles__item-content">
          <div class="last-articles__name"><?=$last_articles_item->post_title?></div>
          <div class="last-articles__description"><?=show_custom_excerpt($last_articles_item->post_content)?></div>
        </div>
      </a><?
    }
    
    wp_reset_postdata(); ?>
  </div>
</section>
<? get_footer() ?>