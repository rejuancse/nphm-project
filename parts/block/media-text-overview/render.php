<?php
/**
 * Block / Media Text Overview
 */

$images = get_field('gallery_image');
$text = get_field('overview');
$link = get_field('link');
$image_alignment = get_field('image_alignment');
$background_color = get_field('background_color');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';
$modifier .= ( isset($background_color) ) ? ' has-background has-background-'. $background_color : '';
$modifier .= ( isset($image_alignment) ) ? ' has-image-'. $image_alignment : '';

if ( $images!='' && $text!='' ): ?>
	<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="media-text-overview block-image-text <?= $modifier; ?>">
		<div class="block-image-text__text">
			<?= $text; ?>
		</div>

		<figure class="block-media-wrap">
			<?php foreach ($images as $image) { ?>
				<div class="img-item">
					<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>" title="<?php echo $image['title']; ?>">

					<span><?php echo $image['description']; ?></span>
				</div>
			<?php } ?>
		</figure>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</section>
<?php endif; ?>
