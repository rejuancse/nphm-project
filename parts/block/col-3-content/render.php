<?php
/**
 * Block / 3-column content
 */

$image = get_field('image');
$text_column_1 = get_field('text_column_1');
$text_column_2 = get_field('text_column_2');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';


if ( $text_column_1!='' && $image!='' ): ?>
	<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-col-3-content <?= $modifier; ?>">
		<?php if ( $text_column_1!='' ){ ?>
			<div class="block-col-3-content__text block-col-3-content__text--1"><?= $text_column_1; ?></div>
		<?php } ?>

		<?php if ( $text_column_2!='' ){ ?>
			<div class="block-col-3-content__text block-col-3-content__text--2"><?= $text_column_2; ?></div>
		<?php } ?>

		<?php if ( $image!='' ){ ?>
			<figure class="block-col-3-content__media-wrap">
				<?= wp_get_attachment_image($image, 'large', false, array('class' => 'block-col-3-content__image')); ?>
			</figure>
		<?php } ?>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</section>
<?php endif; ?>