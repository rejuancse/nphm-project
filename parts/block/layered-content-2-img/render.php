<?php
/**
 * Block / Layered content with 2 images
 */

$page_background_color = get_field('page_background_color', get_the_ID());
$image_top = get_field('image_top');
$image_aside = get_field('image_aside');
$heading = get_field('heading');
$heading_tag = get_field('heading_tag');
$text = get_field('text');
$image_caption = get_field('image_caption');
$text_aside = get_field('text_aside');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';
$modifier .= ( $image_top!='' ) ? ' has-image-top' : '';
$modifier .= ( $text_aside!='' ) ? ' has-text-aside' : '';
$modifier .= ( isset($page_background_color) ) ? ' has-background has-background-'. $page_background_color : '';


if ( $image_aside!='' && $heading!='' && $text!='' ): ?>
	<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-layered-content-2-img <?= $modifier; ?>">
		<?php if ( $image_top!='' ){ ?>
			<figure class="block-layered-content-2-img__media-wrap block-layered-content-2-img__media-wrap--top">
				<?= wp_get_attachment_image($image_top, '2048x2048', false, array('class' => 'block-layered-content-2-img__image')); ?>
			</figure>
		<?php } ?>

		<div class="block-layered-content-2-img__content-wrap">
			<<?= $heading_tag; ?> class="block-layered-content-2-img__heading"><?= $heading; ?></<?= $heading_tag; ?>>

			<?php if ( $image_aside!='' ){ ?>
				<figure class="block-layered-content-2-img__media-wrap block-layered-content-2-img__media-wrap--aside">
					<?= wp_get_attachment_image($image_aside, '1536x1536', false, array('class' => 'block-layered-content-2-img__image')); ?>
				</figure>
			<?php } ?>

			<div class="block-layered-content-2-img__text"><?= $text; ?></div>

			<?php if ( $image_caption!='' || $text_aside!='' ){ ?>
				<div class="block-layered-content-2-img__footer">
					<?php if ( $image_caption!='' ){ ?>
						<div class="block-layered-content-2-img__caption"><?= $image_caption; ?></div>
					<?php } ?>

					<?php if ( $text_aside!='' ){ ?>
						<div class="block-layered-content-2-img__text-aside"><?= $text_aside; ?></div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</section>
<?php endif; ?>