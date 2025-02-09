<?php
/**
 * Block / Event details
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
$price = get_field('price', $post_id);
$link = get_field('link', $post_id);
$button_color = get_field('button_color', $post_id);
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';

$button_modifier = ( isset($button_color) ) ? ' has-background has-'. $button_color .'-background-color' : '';



if ( isset($start_date) || $location!='' || $price!='' || !empty($link) ): ?>
	<ul id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-event-details <?= $modifier; ?>">
		<?php if ( $multi_day && isset($start_date) && isset($end_date) ){ ?>
			<li class="block-event-details__item block-event-details__item--dates">
				<time><?= date('F j, Y', strtotime($start_date)); ?><?= ( $start_time ) ? ' @ '. $start_time : ''; ?> - <?= date('F j, Y', strtotime($end_date)); ?><?= ( $end_time ) ? ' @ '. $end_time : ''; ?></time>	
			</li>
		<?php } else if ( !$multi_day && isset($start_date) ){ ?>
			<li class="block-event-details__item block-event-details__item--dates">
				<time><?= date('l, F j, Y', strtotime($start_date)); ?><?= ( $start_time ) ? ' @ '. $start_time : ''; ?><?= ( $end_time ) ? ' - '. $end_time : ''; ?></time>	
			</li>
		<?php } ?>

		<?php if ( $location!='' ){ ?>
			<li class="block-event-details__item block-event-details__item--location">
				<address>
					<p><?= $location; ?></p>
				</address>
			</li>
		<?php } ?>

		<?php if ( $price!='' ){ ?>
			<li class="block-event-details__item block-event-details__item--price">
				<?= $price; ?>
			</li>
		<?php } ?>

		<?php if ( !empty($link) ){ ?>
			<li class="block-event-details__item block-event-details__item--link block-event-details__link-wrap wp-block-button is-style-outline">
				<a class="block-event-details__link wp-block-button__link wp-element-button <?= $button_modifier; ?>" href="<?= $link['url']; ?>"
				   title="<?= $link['title']; ?>"
				   <?= $link['target']!='' ? 'target="'. $link['target'] .'"' : ''; ?>>

					<?= $link['title']; ?>
				</a>
			</li>
		<?php } ?>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</ul>
<?php endif; ?>