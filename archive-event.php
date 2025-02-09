<?php
/**
 * Archive
 * CPT: Events
 */

get_header();

$events_archive = get_field('events_archive', 'option');
$current_date = date('Y-m');
$view = 'image';
if ( isset($_GET) ){
	$current_date = ( isset($_GET['date']) ) ? $_GET['date'] : date('Y-m');
	$view = ( isset($_GET['view']) ) ? $_GET['view']: '';
	$view = ( !in_array($view, array('image', 'month', 'list')) ) ? 'image' : $view;
}

$page_url = get_post_type_archive_link('event');
$cpt_event_obj = get_post_type_object('event');

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
);
$the_query = new WP_Query($args); ?>


<div class="archive-feed container">
	<?= cs__the_breadcrumbs('default-page__breadcrumbs'); ?>

	<?php get_template_part('parts/section/hero/hero'); ?>

	<ul class="feed-categories has-background-pink">
		<li class="feed-categories__item <?= ( $view=='' || $view=='image' ) ? 'is-active' : ''; ?>">
			<a class="builtin" href="<?= $page_url; ?>">Image view</a>
		</li>
		<li class="feed-categories__item <?= ( $view=='month' ) ? 'is-active' : ''; ?>">
			<a class="builtin" href="<?= $page_url .'?view=month'; ?>">Month view</a>
		</li>
		<li class="feed-categories__item <?= ( $view=='list' ) ? 'is-active' : ''; ?>">
			<a class="builtin" href="<?= $page_url .'?view=list'; ?>">List view</a>
		</li>
	</ul>

	<div class="archive-feed__container">
		<?php if ( $view=='month' ){ ?>
			<?php cs__getEventsCalendar(); ?>

		<?php } else { ?>
			<div class="grid grid--ai-start">
				<div class="archive-feed__sidebar col col--4 col--sm-12 col--xs-12">
					<?php cs__getEventsCalendar(null, 'mini'); ?>

					<?php if ( !empty($taxonomy_event_category) ){ ?>
						<ul class="feed-tags">
							<li class="feed-tags__item is-active">
								<a class="feed-tags__link" href="<?= get_post_type_archive_link('event'); ?>">All</a>
							</li>

							<?php foreach ( $taxonomy_event_category as $id=>$name ){ ?>
								<li class="feed-tags__item">
									<a class="feed-tags__link" href="<?= get_category_link($id); ?>"><?= $name; ?></a>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
				</div>

				<div class="archive-feed__posts col col--8 col--sm-12 col--xs-12 grid grid--1">
					<div class="col">
						<h2 class="archive-feed__subheading">All Events</h2>
					</div>

					<?php if ( $the_query->have_posts() ): ?>
						<?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>
							<div class="archive-feed__item col">
								<?php if ( $view=='image' ){ ?>
									<?php get_template_part('parts/content/event-image-card/event-image-card'); ?>
								<?php } else if ( $view=='list' ){ ?>
									<?php get_template_part('parts/content/event-list-item/event-list-item'); ?>
								<?php } ?>
							</div>
						<?php endwhile; ?>

					<?php else: ?>
						<div class="col">
							<h5><?php _e('Sorry, no events found.', CSWP); ?></h5>
						</div>

					<?php endif; wp_reset_query(); ?>
				</div>
			</div>

		<?php } ?>
	</div>

	<?php if ( !empty($events_archive) ){ ?>
		<?php foreach ( $events_archive as $block_name=>$block_content ){ ?>
			<?php cs__render_acf_block('cs/'. str_replace('_', '-', $block_name) .'', $block_content); ?>
		<?php } ?>
	<?php } ?>
</div>

<?php get_footer(); ?>