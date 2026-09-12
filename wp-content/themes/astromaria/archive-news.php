<?php # Временное наполнение

get_header(); ?>

<?php
if (function_exists('yoast_breadcrumb')) {
    yoast_breadcrumb('<div class="breadcrumbs">', '</div>');
}
?>

<h1>Новости</h1>

<?php if (have_posts()) : ?>

    <div class="news-list">

        <?php while (have_posts()) : the_post(); ?>

            <article class="news-item">

                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium'); ?>
                    </a>
                <?php endif; ?>

                <div>
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php echo esc_html(get_the_date('d.m.Y')); ?>
                    </time>

                    <h2>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>

                    <?php the_excerpt(); ?>

                </div>

            </article>

        <?php endwhile; ?>

    </div>

    <?php
    the_posts_pagination([
        'mid_size'  => 2,
        'prev_text' => '← Назад',
        'next_text' => 'Вперёд →',
    ]);
    ?>

<?php else : ?>

    <p>Новостей пока нет.</p>

<?php endif; ?>

<?php get_footer(); ?>