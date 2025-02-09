<?php get_header(); ?>

<article class="page-404 container">
    <div class="page-404__container grid grid--jc-center">
        <header class="page-404__header col col--8 col--md-12 col--sm-12 col--xs-12">
            <h1 class="page-404__title">Page Not Found</h1>
        </header>
        
        <div class="page-404__content col col--8 col--md-12 col--sm-12 col--xs-12">
            <p class="page-404__subtitle h5">It looks like nothing was found at this location.</p>
            <a class="page-404__button button--outline" href="<?= get_home_url(); ?>" title="To the home page">To the home page</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>