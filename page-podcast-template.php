<?php
/**
 * The Template name: Page with Podcast Template
 */

get_header(); ?>

<div class="default-page container no-gap">
	<?= cs__the_breadcrumbs('fullwidth-page__breadcrumbs'); ?>

	<?php get_template_part('parts/section/subheader/subheader'); ?>

	<?php while ( have_posts() ): the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
</div>

<?php get_footer(); ?>
