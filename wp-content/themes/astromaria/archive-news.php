<? get_header();
yoast_breadcrumb('<div class="breadcrumbs">', '</div>');
?>
<section class="articles articles--list">
  <h1 class="articles__heading">Новости</h1>

  <? if (have_posts()) { ?>
    <div class="articles__content"><?
      while (have_posts()) {
        the_post(); ?>
        <a class="articles__item" href="<? the_permalink() ?>">
          <div class="articles__image" style="background-image: url('<?=get_the_post_thumbnail_url(get_the_ID())?>');"></div>
          <div class="articles__item-content">
            <div class="articles__date"><?=wp_date('j F Y', strtotime(get_the_date()))?></div>
            <div class="articles__name"><? the_title() ?></div>
            <div class="articles__description"><?=show_custom_excerpt(get_the_excerpt())?></div>
          </div>
        </a>
      <? } ?>
    </div><?

    the_posts_pagination([
      'mid_size'  => 2,
      'prev_text' => '← Назад',
      'next_text' => 'Вперёд →',
    ]);
  } ?>
</section>
<? get_footer() ?>