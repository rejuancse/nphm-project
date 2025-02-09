<?php get_header(); ?>

<div class="news-feed container">
    <header class="news-feed__header grid grid--1">
        <div class="col">
            <h1 class="news-feed__title"><?php _e('Latest Posts', CSWP); ?></h1>
        </div>
    </header>

    <div class="news-feed__container grid">
        <?php if ( have_posts() ): ?>
            <?php while ( have_posts() ): the_post(); ?>
                <div class="news-feed__item col col--4 col--md-6 col--sm-6 col--xs-12">
                    <?php get_template_part('parts/content/post-card'); ?>
                </div>
            <?php endwhile; ?>

        <?php else: ?>
            <div class="news-feed__item col col--12">
                <h2><?php _e('Sorry, no posts found.', CSWP); ?></h2>
            </div>

        <?php endif; ?>
    </div>

    <footer class="news-feed__footer grid grid--1">
        <div class="col">
            <?php cs__the_pagination(); ?>
        </div>
    </footer>
</div>

<?php get_footer(); ?>