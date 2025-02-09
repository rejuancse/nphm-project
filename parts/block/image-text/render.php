<?php
/**
 * Block / Image & text
 */

$page_background_color = get_field('page_background_color', get_the_ID());
$image = get_field('image');
$badge = get_field('badge');
$link = get_field('link');
$text = get_field('text');
$image_alignment = get_field('image_alignment');
$image_width = get_field('image_width');
$crop_image_to_fill = get_field('crop_image_to_fill');
$background_color = get_field('background_color');
$badge_color = get_field('badge_color');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$background_color = ( $background_color=='default' && $page_background_color!='' ) ? $page_background_color : $background_color;

$modifier = ( isset($block['className']) ) ? $block['className'] : '';
$modifier .= ( isset($background_color) ) ? ' has-background has-background-'. $background_color : '';
$modifier .= ( isset($badge_color) ) ? ' has-badge-'. $badge_color : '';
$modifier .= ( isset($image_alignment) ) ? ' has-image-'. $image_alignment : '';
$modifier .= ( $crop_image_to_fill ) ? ' has-image-cropped' : '';


if ( $image!='' && $text!='' ): ?>
	<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-image-text <?= $modifier; ?>">
		<figure class="block-image-text__media-wrap" style="flex: 0 0 <?= $image_width .'%'; ?>; max-width: <?= $image_width .'%'; ?>;">
			<?= wp_get_attachment_image($image, 'large', false, array('class' => 'block-image-text__image')); ?>
			
			<?php if ( $badge!='' ){ ?>
				<figcaption class="block-image-text__media-caption"><?= $badge; ?></figcaption>
			<?php } ?>
		</figure>

		<div class="block-image-text__text">
			<?= $text; ?>
			
			<?php if ( !empty($link) ){ ?>
				<div class="block-image-text__link-wrap wp-block-button is-style-arrow">
					<a class="block-image-text__link wp-block-button__link wp-element-button" href="<?= $link['url']; ?>"
					   title="<?= $link['title']; ?>"
					   <?= $link['target']!='' ? 'target="'. $link['target'] .'"' : ''; ?>>

						<?= $link['title']; ?>
					</a>
				</div>
			<?php } ?>
		</div>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</section>
<?php endif; ?>