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
<section class="articles">
  <div class="articles__header">
    <h2 class="articles__heading">Последние новости</h2>
    <a class="articles__header-link" href="/news/">Смотреть все новости &#8594</a>
  </div>
  <div class="articles__content"><?
    foreach ($last_news as $last_news_item) {
      setup_postdata($post); ?>
      <a class="articles__item" href="<?=get_permalink($last_news_item->ID)?>">
        <div class="articles__image" style="background-image: url('<?=get_the_post_thumbnail_url($last_news_item->ID)?>');"></div>
        <div class="articles__item-content">
          <div class="articles__date"><?=wp_date('j F Y', strtotime($last_news_item->post_date))?></div>
          <div class="articles__name"><?=$last_news_item->post_title?></div>
          <div class="articles__description"><?=show_custom_excerpt($last_news_item->post_content)?></div>
        </div>
      </a><?
    }
    
    wp_reset_postdata(); ?>
  </div>
</section>
<section class="articles">
  <div class="articles__header">
    <h2 class="articles__heading">Популярные статьи</h2>
    <a class="articles__header-link" href="/articles/">Смотреть все статьи &#8594</a>
  </div>
  <div class="articles__content"><?
    foreach ($last_articles as $last_articles_item) {
      setup_postdata($post); ?>
      <a class="articles__item" href="<?=get_permalink($last_articles_item->ID)?>">
        <div class="articles__image" style="background-image: url('<?=get_the_post_thumbnail_url($last_articles_item->ID)?>');"></div>
        <div class="articles__item-content">
          <div class="articles__name"><?=$last_articles_item->post_title?></div>
          <div class="articles__description"><?=show_custom_excerpt($last_articles_item->post_content)?></div>
        </div>
      </a><?
    }
    
    wp_reset_postdata(); ?>
  </div>
</section>
<? get_footer() ?>