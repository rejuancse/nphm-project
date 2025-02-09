<?php
/**
 * Content / Event list item
 */

$post_id = get_the_ID();
$multi_day = get_field('multi_day', $post_id);
$start_date = get_field('start_date', $post_id);
$start_time = get_field('start_time', $post_id);
$end_time = get_field('end_time', $post_id);
if ( $multi_day ){
	$end_date = get_field('end_date', $post_id);
}
$location = get_field('location', $post_id);

$post_terms = get_the_terms($post_id, 'event_category');

$modifier = ( isset($args['modifier']) ) ? $args['modifier'] : ''; ?>


<article id="post-<?php the_ID(); ?>" <?php post_class('event-list-item '. $modifier); ?>>
	<h5 class="event-list-item__heading">
		<a class="builtin" href="<?php the_permalink(); ?>" title="Learn more: <?php the_title(); ?>"><?php the_title(); ?></a>
	</h5>

	<div class="event-list-item__time"><?= cs__getEventDate($post_id, '', true); ?></div>
	
	<div class="event-list-item__footer">
		<?php if ( !empty($post_terms) ) { ?>
			<div class="event-list-item__terms wp-block-button is-style-outline">
				<?php foreach ( $post_terms as $term ){ ?>
					<a class="event-list-item__term-link wp-block-button__link wp-element-button has-plum-background-color" href="<?= get_term_link($term, 'event_category'); ?>"><?= $term->name; ?></a>
				<?php } ?>
			</div>
		<?php } ?>

		<div class="event-list-item__details">
			<?= cs__getEventTime( $post_id, true ); ?>
			
			<?php if ( $location!='' ){ ?>
				<address><?= $location; ?></address>
			<?php } ?>
		</div>
	</div>
</article>