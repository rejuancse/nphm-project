<?php
/**
 * Block / NPHM Info block
 */

$headline = get_field('headline');
$button = get_field('button');
$button_url         = $button ? $button['url'] : '';
$button_text        = $button ? $button['title'] : '';
$button_target      = $button ? $button['target'] : '';

$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';
$modifier .= ( isset($layout) ) ? ' is-style-'. $layout : '';
$modifier .= ( isset($layout) && $layout=='with-image' ) ? ' has-image-'. $image_position : '';
$modifier .= ( isset($layout) && $layout=='with-text' ) ? ' has-text-'. $text_position : '';
?>

<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-nphm-info <?= $modifier; ?>">
	<div class="block-info-wrap">
		<?php if( !empty($headline) ) { ?>
			<h2><?= $headline; ?></h2>
		<?php } ?>

		<?php if( !empty($button_url) ) { ?>
			<div class="highlight-card__link-wrap wp-block-button is-style-arrow">
				<a class="highlight-card__link wp-block-button__link wp-element-button" href="<?= esc_url($button_url); ?>" title="See more" target="<?= $button_target ?>" target="<?= $button_target ?>">
					<?= $button_text ?>
				</a>
			</div>
		<?php } ?>
	</div>

	<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
</section>
