<?php get_header(); ?>

<div class="default-page container">
	<?= cs__the_breadcrumbs('default-page__breadcrumbs'); ?>

	<?php get_template_part('parts/section/hero/hero'); ?>

	<?php while ( have_posts() ): the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
<?php get_footer(); ?>
