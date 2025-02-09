<?php
/**
 * Archive
 * CPT: Exhibition
 */

get_header();

$page_url = get_post_type_archive_link('exhibition');

$args = array(
	'taxonomy' => 'exhibition_category',
	'fields' => 'id=>name',
	'hide_empty' => true,
);
$taxonomy_exhibition_category = get_categories($args);

$the_query = new WP_Query(array(
	'post_type'	=> 'exhibition',
	'posts_per_page' => -1,
	// 'tax_query' => array(
	// 	array(
	// 		'taxonomy' => 'exhibition_category',
	// 		'field' => 'slug',
	// 		'terms' => array('installations'),
	// 		'operator' => 'NOT IN'
	// 	),
	// )
)); ?>


<div class="archive-feed container">
	<?= cs__the_breadcrumbs('default-page__breadcrumbs'); ?>

	<?php get_template_part('parts/section/hero/hero'); ?>

	<?php if ( !empty($taxonomy_exhibition_category) ){ ?>
		<ul class="feed-categories has-background-lemon">
			<li class="feed-categories__item is-active">
				<a class="builtin" href="<?= get_post_type_archive_link('exhibition'); ?>">All</a>
			</li>

			<?php foreach ( $taxonomy_exhibition_category as $id=>$name ){ ?>
				<li class="feed-categories__item">
					<a class="builtin" href="<?= get_category_link($id); ?>"><?= $name; ?></a>
				</li>
			<?php } ?>
		</ul>
	<?php } ?>

	<div class="archive-feed__container <?= $container_modifier; ?>">
		<?php if ( $the_query->have_posts() ): ?>
			<div class="grid">
				<?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>
					<div class="archive-feed__item col col--4 col--lg-6 col--md-4 col--sm-6 col--xs-12">
						<?php get_template_part('parts/content/exhibition-card/exhibition-card'); ?>
					</div>
				<?php endwhile; ?>
			</div>

		<?php else: ?>
			<h2><?php _e('Sorry, no posts found.', CSWP); ?></h2>

		<?php endif; wp_reset_query(); ?>
	</div>
</div>

<?php get_footer(); ?>