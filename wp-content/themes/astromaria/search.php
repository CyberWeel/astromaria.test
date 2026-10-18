<? get_header();
yoast_breadcrumb('<div class="breadcrumbs">', '</div>');

$search_query = get_search_query();
$counts = array('all' => 0, 'post' => 0, 'news' => 0);
$results = array();

if (have_posts()) {
  while (have_posts()) {
    the_post();

    $type = get_post_type();

    $results[] = array(
      'date' => wp_date('j F Y', strtotime(get_the_date())),
      'excerpt' => show_custom_excerpt(get_the_excerpt()),
      'image' => get_the_post_thumbnail_url(),
      'title' => get_the_title(),
      'url' => get_permalink(),
      'type' => $type
    );

    $counts[$type]++;
    $counts['all']++;
  }
} ?>
<section class="searchpage">
  <h1 class="searchpage__heading">Результаты поиска по запросу «<?=esc_html($search_query)?>»</h1>
  <? if ($counts['all'] > 0) { ?>
    <div class="searchpage__tabs">
      <button class="searchpage__tab searchpage__tab--active" type="button" data-category="all">Все результаты (<?=$counts['all']?>)</button><?
      
      if ($counts['post'] > 0) { ?>
        <button class="searchpage__tab" type="button" data-category="post">Статьи (<?=$counts['post']?>)</button><?
      }

      if ($counts['news'] > 0) { ?>
        <button class="searchpage__tab" type="button" data-category="news">Новости (<?=$counts['news']?>)</button>
      <? } ?>
    </div>
    <div class="articles__content">
      <? foreach ($results as $result) { ?>
        <a class="articles__item" href="<?=esc_url($result['url'])?>" data-category="<?=esc_attr($result['type'])?>">
          <div class="articles__badge <?=$result['type'] === 'news' ? 'articles__badge--news' : 'articles__badge--post'?>"><?=$result['type'] === 'news' ? 'Новость' : 'Статья'?></div>
          <div class="articles__image" style="background-image: url('<?=$result['image']?>');"></div>
          <div class="articles__item-content">
            <div class="articles__date"><?=$result['date']?></div>
            <div class="articles__name"><?=highlight($result['title'], $search_query)?></div>
            <div class="articles__description"><?=highlight($result['excerpt'], $search_query)?></div>
          </div>
        </a>
      <? } ?>
    </div>
  <? } else { ?>
    <p class="searchpage__nothing">По вашему запросу ничего не найдено.</p>
  <? } ?>
</section>
<? get_footer() ?>