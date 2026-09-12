<?php # Временное наполнение

get_header(); ?>

<?php
if (function_exists('yoast_breadcrumb')) {
    yoast_breadcrumb('<div class="breadcrumbs">', '</div>');
}
?>

<?php while (have_posts()) : the_post(); ?>

    <article>

        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
            <?php echo esc_html(get_the_date('d.m.Y')); ?>
        </time>

        <h1><?php the_title(); ?></h1>

        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('large'); ?>
        <?php endif; ?>

        <div>
            <?php the_content(); ?>
        </div>

    </article>

    <div class="single-article__navigation">

        <div>
            <?php previous_post_link('%link', '← Предыдущая статья'); ?>
        </div>

        <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>">
            Все статьи
        </a>

        <div>
            <?php next_post_link('%link', 'Следующая статья →'); ?>
        </div>

    </div>

<?php endwhile; ?>


<a href="<?php echo esc_url(home_url('/articles/')); ?>">
    Все статьи
</a>

<?php get_footer(); ?>