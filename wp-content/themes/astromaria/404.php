<? get_header();
yoast_breadcrumb('<div class="breadcrumbs">', '</div>');
?>
<section class="page404">
  <h1 class="page404__heading">Страница не найдена</h1>
  <a class="page404__link" href="<?=esc_url(home_url('/'))?>">Вернуться на главную</a>
</section>
<? get_footer() ?>