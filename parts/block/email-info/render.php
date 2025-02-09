<?php
/**
 * Block / Email Info
 */

$email_info = get_field('email_info');
$banner_image = get_field('banner_image');

$image_alignment = get_field('image_alignment');
$image_width = get_field('image_width');
$background_color = get_field('background_color');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';
$modifier .= ( isset($background_color) ) ? ' has-background has-background-'. $background_color : '';
$modifier .= ( isset($image_alignment) ) ? ' has-image-'. $image_alignment : '';

if ( !empty($email_info) ): ?>
	<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="email-info-wrap <?= $modifier; ?>">

		<div class="block-email-info">
			<?php
			foreach( $email_info as $value ) {
				$button_url         = $value['button'] ? $value['button']['url'] : '';
				$button_text        = $value['button'] ? $value['button']['title'] : '';
				$button_target      = $value['button'] ? $value['button']['target'] : ''; ?>

				<div class="block__item" style="background-color: <?= $value['background_color']; ?>">
					<?php if( !empty($value['title']) ) { ?>
						<h3><?php echo $value['title']; ?></h3>
					<?php } ?>

					<?php if( !empty($value['descriptions']) ) { ?>
						<p><?php echo $value['descriptions']; ?></p>
					<?php } ?>

					<?php if( !empty($button_url) ) { ?>
						<div class="button-wrap">
							<a href="<?= esc_url($button_url); ?>" class="btn btn-primary" target="<?= $button_target ?>">
								<?= $button_text ?>
							</a>
						</div>
					<?php } ?>

				</div>
			<?php } ?>

			<div class="block__item banner-image">
				<img src="<?php echo $banner_image['url']; ?>" alt="<?php echo $banner_image['alt']; ?>">
			</div>
		</div>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</section>
<?php endif; ?>
