<?php
/**
 * Block / Contact information
 */

$content_type = get_field('content_type');
$cta_title = get_field('cta_title');
$cta_link = get_field('cta_link');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

if ( $content_type=='form' ){
	$heading = get_field('heading');
	$form = get_field('form');
} else if ( $content_type=='text' ){
	$text = get_field('text');
}

$modifier = ( isset($block['className']) ) ? $block['className'] : '';
$modifier .= ( isset($content_type) ) ? ' is-type-'. $content_type : '';


if ( ( $content_type=='form' && $heading!='' && $form!='' ) || ( $content_type=='text' && $text!='' ) ): ?>
	<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-contact-info <?= $modifier; ?> grid grid--2 grid--xs-1">
		<div class="block-contact-info__form-wrap col">
			<?php if ( $content_type=='form' && $heading!='' && $form!='' ){ ?>
				<p class="block-contact-info__heading"><?= $heading; ?></p>

				<div class="block-contact-info__form"><?= $form; ?></div>

			<?php } else if ( $content_type=='text' && $text!='' ){ ?>
				<div class="block-contact-info__text"><?= $text; ?></div>

			<?php } ?>
		</div>

		<?php if ( $cta_title!='' && $cta_link!='' ){ ?>
			<div class="block-contact-info__link-wrap col">
				<a class="block-contact-info__link" href="<?= $cta_link; ?>"
				   target="_blank">

					<?= $cta_title; ?>
				</a>
			</div>
		<?php } ?>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</section>
<?php endif; ?>