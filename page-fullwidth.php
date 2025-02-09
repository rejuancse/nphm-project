<?php
/**
 * The Template name: Full page With Container
 */

get_header(); ?>

<div class="default-page container no-gap">
	<?= cs__the_breadcrumbs('fullwidth-page__breadcrumbs'); ?>

	<?php while ( have_posts() ): the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
</div>

<?php get_footer(); ?>
