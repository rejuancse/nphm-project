<?php
/**
 * The Template name: Page Full Width With Hero Section
 */

get_header(); ?>

<div class="default-page container no-gap">
	<?= cs__the_breadcrumbs('fullwidth-page__breadcrumbs'); ?>

	<?php get_template_part('parts/section/hero/hero'); ?>

	<?php while ( have_posts() ): the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
</div>

<?php get_footer(); ?>
