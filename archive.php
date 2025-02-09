<?php get_header(); ?>

<div class="archive-feed container">
	<?= cs__the_breadcrumbs('default-page__breadcrumbs'); ?>

	<?php get_template_part('parts/section/hero/hero'); ?>

	<div class="archive-feed__container <?= $container_modifier; ?>">
		<?php if ( have_posts() ): ?>
			<div class="grid">
				<?php while ( have_posts() ): the_post(); ?>
				<div class="archive-feed__item col col--4 col--lg-6 col--md-4 col--sm-6 col--xs-12">
						<?php get_template_part('parts/content/post-card/post-card'); ?>
					</div>
				<?php endwhile; ?>
			</div>

			<?php cs__the_pagination(); ?>

		<?php else: ?>
			<h2><?php _e('Sorry, no posts found.', CSWP); ?></h2>

		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>