<?php
/**
 * Content / Event image card
 */

$post_id = get_the_ID();
$multi_day = get_field('multi_day', $post_id);
$start_time = get_field('start_time', $post_id);
$start_date = get_field('start_date', $post_id);
$end_time = get_field('end_time', $post_id);
if ( $multi_day ){
	$end_date = get_field('end_date', $post_id);
}
$location = get_field('location', $post_id);

$post_terms = get_the_terms($post_id, 'event_category');

$modifier = ( isset($args['modifier']) ) ? $args['modifier'] : '';
$time_modifier = ( !$multi_day && isset($start_date) ) ? ' event-image-card__time--one-big' : '';
if ( $multi_day ){
	$start_date = ( $start_date!='' ) ? strtotime($start_date) : '';
	$end_date = ( $end_date!='' ) ? strtotime($end_date) : '';

	$time_modifier = ( date('F', $start_date)==date('F', $end_date) && date('Y', $start_date)==date('Y', $end_date) ) ? ' event-image-card__time--two-big' : '';
} ?>


<article id="post-<?php the_ID(); ?>" <?php post_class('event-image-card '. $modifier); ?>>
	<a class="event-image-card__link" href="<?php the_permalink(); ?>" title="Learn more: <?php the_title(); ?>"></a>

	<div class="event-image-card__time<?= $time_modifier; ?>">
		<?= cs__getEventDate($post_id, 'formatted', true); ?>
	</div>

	<?php if ( has_post_thumbnail() ){ ?>
		<figure class="event-image-card__media-wrap">
			<?= wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'medium_large', false, array('class' => 'event-image-card__image')); ?>
		</figure>
	<?php } else { ?>
		<div class="event-image-card__content-wrap">
			<h4 class="event-image-card__heading"><?php the_title(); ?></h4>

			<div class="event-image-card__text">
				<p><?php the_excerpt(); ?></p>
			</div>
		</div>
	<?php } ?>
	
	<div class="event-image-card__footer">
		<?php if ( !empty($post_terms) ) { ?>
			<div class="event-image-card__terms wp-block-button is-style-outline">
				<?php foreach ( $post_terms as $term ){ ?>
					<a class="event-image-card__term-link wp-block-button__link wp-element-button has-plum-background-color" href="<?= get_term_link($term, 'event_category'); ?>"><?= $term->name; ?></a>
				<?php } ?>
			</div>
		<?php } ?>

		<div class="event-image-card__details">
			<?= cs__getEventTime( $post_id, true ); ?>
			
			<?php if ( $location!='' ){ ?>
				<address><?= $location; ?></address>
			<?php } ?>
		</div>
	</div>
</article>