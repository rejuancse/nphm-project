<?php
/**
 * Block / Layered caption gallery
 */

$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';


if ( have_rows('blocks') ): ?>
	<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-layered-caption-gallery <?= $modifier; ?>">
		<div class="block-layered-caption-gallery__grid-sizer"></div>

		<?php while ( have_rows('blocks') ): the_row();
			$image = get_sub_field('image');
			$text = get_sub_field('text');
			$url = get_sub_field('url'); ?>

			<?php if ( $image!='' ){
				$image_metadata = wp_get_attachment_metadata($image);
				if ( !empty($image_metadata) ) {
					$item_modifier = ( $image_metadata['width']/$image_metadata['height']>1.1 ) ? 'is-wide' : 'is-tall';
				} ?>

				<figure class="block-layered-caption-gallery__item block-layered-caption-gallery__media-wrap <?= $item_modifier; ?>">
					<?= wp_get_attachment_image($image, 'large', false, array('class' => 'block-layered-caption-gallery__image')); ?>
				
					<?php if ( $text!='' && $url!='' ){ ?>
						<figcaption class="block-layered-caption-gallery__media-caption wp-block-button is-style-arrow">
							<a class="wp-block-button__link wp-element-button" href="<?= $url; ?>"><?= $text; ?></a>
						</figcaption>
					<?php } else if ( $text!='' ) { ?>
						<figcaption class="block-layered-caption-gallery__media-caption"><?= $text; ?></figcaption>
					<?php } ?>
				</figure>
			<?php } ?>
		<?php endwhile; ?>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</section>
<?php endif; ?>