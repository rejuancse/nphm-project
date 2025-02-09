<?php
/**
 * Block / Header
 */

$heading = get_field('heading');
$link = get_field('link');
$heading_tag = get_field('heading_tag');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';


if ( $heading!='' ): ?>
	<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-header <?= $modifier; ?> grid">
		<<?= $heading_tag; ?> class="block-header__heading col col--8 col--sm-12 col--xs-12"><?= $heading; ?></<?= $heading_tag; ?>>

		<?php if ( !empty($link) ){ ?>
			<div class="block-header__link-wrap wp-block-button is-style-arrow col col--4 col--sm-12 col--xs-12">
				<a class="block-header__link wp-block-button__link wp-element-button" href="<?= $link['url']; ?>"
				   title="<?= $link['title']; ?>"
				   <?= $link['target']!='' ? 'target="'. $link['target'] .'"' : ''; ?>>

					<?= $link['title']; ?>
				</a>
			</div>
		<?php } ?>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</section>
<?php endif; ?>