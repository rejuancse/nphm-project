<?php
/**
 * Block / Events layout
 */

$category = get_field('category');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$current_date = date('Y-m');
if ( isset($_GET) ){
	$current_date = ( isset($_GET['date']) ) ? $_GET['date'] : date('Y-m');
}

$page_url = get_post_type_archive_link('event');

$args = array(
	'taxonomy' => 'event_category',
	'fields' => 'id=>name',
	'hide_empty' => true,
);
$taxonomy_event_category = get_categories($args);

if ( $current_date==date('Y-m') ){
	$interval_start = date('Y-m-01');
	$interval_end = date('Y-m-t');
} else if ( $current_date!='' ) {
	$interval_start = date($current_date .'-01');
	$interval_end = date($current_date .'-t');
}
$args = array(
	'post_type'	=> 'event',
	'posts_per_page' => -1,
	'meta_key' => 'start_date',
	'orderby' => 'meta_value',
	'order' => 'ASC',
	'meta_query' => array(
		'relation' => 'OR',
		array(
			'key' => 'start_date',
			'compare' => 'BETWEEN',
			'value' => array($interval_start, $interval_end),
			'type' => 'DATETIME',
		),
		array(
			'key' => 'end_date',
			'compare' => 'BETWEEN',
			'value' => array($interval_start, $interval_end),
			'type' => 'DATETIME',
		)
	),
	'tax_query'	=> array(
		array(
			'taxonomy' => 'event_category',
			'field' => 'id',
			'terms' => array($category)
		)
	)
);
$the_query = new WP_Query($args);

$modifier = ( isset($block['className']) ) ? $block['className'] : ''; ?>


<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-events-layout <?= $modifier; ?>">
	<div class="grid grid--ai-start">
		<div class="block-events-layout__sidebar col col--4 col--sm-12 col--xs-12">
			<?php cs__getEventsCalendar($category, 'mini'); ?>

			<?php if ( !empty($taxonomy_event_category) ){ ?>
				<ul class="feed-tags">
					<li class="feed-tags__item">
						<a class="feed-tags__link" href="<?= get_post_type_archive_link('event'); ?>">All</a>
					</li>

					<?php foreach ( $taxonomy_event_category as $id=>$name ){ ?>
						<li class="feed-tags__item<?= ( $id==$category ) ? ' is-active' : ''; ?>">
							<a class="feed-tags__link" href="<?= get_category_link($id); ?>"><?= $name; ?></a>
						</li>
					<?php } ?>
				</ul>
			<?php } ?>
		</div>

		<div class="block-events-layout__posts col col--8 col--sm-12 col--xs-12 grid grid--1">
			<?php if ( $the_query->have_posts() ): ?>
				<?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>
					<div class="block-events-layout__item col">
						<?php get_template_part('parts/content/event-image-card/event-image-card'); ?>
					</div>
				<?php endwhile; ?>

			<?php else: ?>
				<div class="col">
					<h5><?php _e('Sorry, no events found.', CSWP); ?></h5>
				</div>

			<?php endif; wp_reset_query(); ?>
		</div>
	</div>

	<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
</section>