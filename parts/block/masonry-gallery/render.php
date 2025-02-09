<?php
/**
 * Block / Masonry gallery
 */

$blocks = get_field('blocks');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';


if ( !empty($blocks) ): ?>
	<div id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-masonry-gallery <?= $modifier; ?>">
		<?php foreach( $blocks as $item ):
			$caption = wp_get_attachment_caption($item); ?>

			<figure class="block-masonry-gallery__item block-masonry-gallery__media-wrap">
				<?= wp_get_attachment_image($item, 'large', false, array('class' => 'block-masonry-gallery__image')); ?>

				<?php if ( $caption!='' ){ ?>
					<figcaption class="block-masonry-gallery__media-caption"><?= $caption; ?></figcaption>
				<?php } ?>
			</figure>
		<?php endforeach; ?>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</div>
<?php endif; ?>