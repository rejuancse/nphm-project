<?php get_header();

$page_for_posts = get_option('page_for_posts');
$current_category = get_queried_object();

$page_background_color = get_field('page_background_color', $page_for_posts);

$args = array(
	'taxonomy' => 'category',
	'fields' => 'id=>name',
	'exclude' => '1',
	'hide_empty' => true,
);
$taxonomy_category = get_categories($args);

$cardModifier = '';
$cardModifier .= ( isset($page_background_color) ) ? ' has-background has-background-'. $page_background_color : '';  ?>

<div class="archive-feed container">
	<?= cs__the_breadcrumbs('default-page__breadcrumbs'); ?>

	<?php get_template_part('parts/section/hero/hero'); ?>

	<?php if ( !empty($taxonomy_category) ){ ?>
		<ul class="feed-categories has-background-<?= $page_background_color; ?>">
			<li class="feed-categories__item">
				<a class="builtin" href="<?= get_permalink($page_for_posts); ?>">All</a>
			</li>

			<?php foreach ( $taxonomy_category as $id=>$name ){ ?>
				<li class="feed-categories__item <?= $current_category->term_id==$id ? 'is-active' : ''; ?>">
					<a class="builtin" href="<?= get_category_link($id); ?>"><?= $name; ?></a>
				</li>
			<?php } ?>
		</ul>
	<?php } ?>

	<div class="archive-feed__container">
		<?php if ( have_posts() ): ?>
			<div class="grid">
				<?php while ( have_posts() ): the_post(); ?>
					<div class="archive-feed__item col col--4 col--lg-6 col--md-4 col--sm-6 col--xs-12">
						<?php get_template_part('parts/content/post-card/post-card', '', array('modifier' => $cardModifier)); ?>
					</div>
				<?php endwhile; ?>
			</div>

			<?php cs__the_pagination(); ?>

		<?php else: ?>
			<h2><?php _e('Sorry, no posts found.', CSWP); ?></h2>

		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>