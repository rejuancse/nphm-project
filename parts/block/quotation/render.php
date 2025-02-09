<?php
/**
 * Block / Quotation
 */

$quote = get_field('quote');
$citation = get_field('citation');
$layout = get_field('layout');
$font_size = get_field('font_size');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$image = ( isset($layout) && $layout=='with-image' ) ? get_field('image') : '';
$image_position = ( isset($layout) && $layout=='with-image' ) ? get_field('image_position') : '';

$text = ( isset($layout) && $layout=='with-text' ) ? get_field('text') : '';
$text_position = ( isset($layout) && $layout=='with-text' ) ? get_field('text_position') : '';

$modifier = ( isset($block['className']) ) ? $block['className'] : '';
$modifier .= ( isset($layout) ) ? ' is-style-'. $layout : '';
$modifier .= ( isset($font_size) ) ? ' has-size-'. $font_size : '';
$modifier .= ( isset($citation) && $citation!='' ) ? ' has-citation' : '';
$modifier .= ( isset($layout) && $layout=='with-image' ) ? ' has-image-'. $image_position : '';
$modifier .= ( isset($layout) && $layout=='with-text' ) ? ' has-text-'. $text_position : '';


if ( $quote!='' ): ?>
	<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-quotation <?= $modifier; ?>">
		<div class="block-quotation__quote-wrap">
			<blockquote class="block-quotation__quote">
				<div class="block-quotation__quote-content"><?= $quote; ?></div>

				<?php if ( $citation ){ ?>
					<cite class="block-quotation__citation"><?= $citation; ?></cite>
				<?php } ?>
			</blockquote>
		</div>

		<?php if ( isset($layout) && $layout=='with-image' && $image!='' ){ ?>
			<figure class="block-quotation__media-wrap">
				<?= wp_get_attachment_image($image, 'medium_large', false, array('class' => 'block-quotation__image')); ?>
			</figure>
		<?php } ?>

		<?php if ( isset($layout) && $layout=='with-text' && $text!='' ){ ?>
			<div class="block-quotation__text"><?= $text; ?></div>
		<?php } ?>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</section>
<?php endif; ?>