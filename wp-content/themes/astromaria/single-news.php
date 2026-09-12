<?php # Временное наполнение

get_header(); ?>

<?php
if (function_exists('yoast_breadcrumb')) {
    yoast_breadcrumb('<div class="breadcrumbs">', '</div>');
}
?>

<?php while (have_posts()) : the_post(); ?>

    <article class="single-news">

        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
            <?php echo esc_html(get_the_date('d.m.Y')); ?>
        </time>

        <h1><?php the_title(); ?></h1>

        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('large'); ?>
        <?php endif; ?>

        <div class="single-news__content">
            <?php the_content(); ?>
        </div>

    </article>

    <div class="single-news__navigation">

        <div>
            <?php previous_post_link('%link', '← Предыдущая новость'); ?>
        </div>

        <a href="<?php echo esc_url(get_post_type_archive_link('news')); ?>">
            Все новости
        </a>

        <div>
            <?php next_post_link('%link', 'Следующая новость →'); ?>
        </div>

    </div>

<?php endwhile; ?>

<?php get_footer(); ?>