<?php
/**
 * Taxonomy: Category
 * CPT: Exhibition
 */

get_header();

$ppp = get_option('posts_per_page');
$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
$page_url = get_term_link(get_queried_object(), 'program_category');

$current_term = get_queried_object();

$args = array(
	'taxonomy' => 'program_category',
	'fields' => 'id=>name',
	'hide_empty' => true,
);
$taxonomy_program_category = get_categories($args);

$the_query = new WP_Query(array(
	'post_type'	=> 'program',
	'posts_per_page' => $ppp,
	'offset' => ($paged-1)*$ppp,
	'tax_query'	=> array(
		array(
			'taxonomy' => 'program_category',
			'field' => 'id',
			'terms' => array($current_term->term_id)
		)
	)
)); ?>


<div class="archive-feed container">
	<?= cs__the_breadcrumbs('default-page__breadcrumbs'); ?>

	<?php get_template_part('parts/section/hero/hero'); ?>

	<?php if ( !empty($taxonomy_program_category) ){ ?>
		<ul class="feed-categories has-background-mint">
			<li class="feed-categories__item">
				<a class="builtin" href="<?= get_post_type_archive_link('program'); ?>">All</a>
			</li>

			<?php foreach ( $taxonomy_program_category as $id=>$name ){ ?>
				<li class="feed-categories__item <?= $current_term->term_id==$id ? 'is-active' : ''; ?>">
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
						<?php get_template_part('parts/content/program-card/program-card'); ?>
					</div>
				<?php endwhile; ?>
			</div>

			<?php cs__the_pagination($page_url, $the_query->max_num_pages); ?>

		<?php else: ?>
			<h2><?php _e('Sorry, no posts found.', CSWP); ?></h2>

		<?php endif; wp_reset_query(); ?>
	</div>
</div>

<?php get_footer(); ?>