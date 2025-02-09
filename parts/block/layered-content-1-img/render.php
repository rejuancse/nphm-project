<?php
/**
 * Block / Layered content with 1 image
 */

$page_background_color = get_field('page_background_color', get_the_ID());
$heading = get_field('heading');
$heading_tag = get_field('heading_tag');
$text = get_field('text');
$image_caption = get_field('image_caption');
$image = get_field('image');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';
$modifier .= ( isset($page_background_color) ) ? ' has-background has-background-'. $page_background_color : '';


if ( $text!='' && $image!='' ): ?>
	<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-layered-content-1-img <?= $modifier; ?> grid grid--ai-start">
		<div class="block-layered-content-1-img__content-wrap col col--7 col--xs-12">
			<?php if ( $heading!='' && $heading_tag!='' ){ ?>
				<<?= $heading_tag; ?> class="block-layered-content-1-img__heading"><?= $heading; ?></<?= $heading_tag; ?>>
			<?php } ?>

			<div class="block-layered-content-1-img__text"><?= $text; ?></div>

			<?php if ( $image_caption!='' ){ ?>
				<div class="block-layered-content-1-img__footer">
					<div class="block-layered-content-1-img__caption"><?= $image_caption; ?></div>
				</div>
			<?php } ?>
		</div>

		<?php if ( $image!='' ){ ?>
			<figure class="block-layered-content-1-img__media-wrap col col--5 col--xs-12">
				<?= wp_get_attachment_image($image, '1536x1536', false, array('class' => 'block-layered-content-1-img__image')); ?>
			</figure>
		<?php } ?>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</section>
<?php endif; ?>