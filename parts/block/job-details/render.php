<?php
/**
 * Block / Job details
 */

$link = get_field('link');
$button_color = get_field('button_color');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';

$button_modifier = ( isset($button_color) ) ? ' has-background has-'. $button_color .'-background-color' : '';


if ( have_rows('blocks') ): ?>
	<dl id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-job-details <?= $modifier; ?>">
		<?php while ( have_rows('blocks') ): the_row();
			$heading = get_sub_field('heading');
			$text = get_sub_field('text'); ?>

			<?php if ( $heading!='' && $text!='' ){ ?>
				<dt class="block-job-details__heading"><?= $heading; ?></dt>
				<dd class="block-job-details__text"><?= $text; ?></dd>
			<?php } ?>
		<?php endwhile; ?>

		<?php if ( !empty($link) ){ ?>
			<dt class="block-job-details__heading"></dt>
			<dd class="block-job-details__text block-job-details__text--link block-job-details__link-wrap wp-block-button is-style-outline">
				<a class="block-job-details__link wp-block-button__link wp-element-button <?= $button_modifier; ?>" href="<?= $link['url']; ?>"
				   title="<?= $link['title']; ?>"
				   <?= $link['target']!='' ? 'target="'. $link['target'] .'"' : ''; ?>>

					<?= $link['title']; ?>
				</a>
			</li>
		<?php } ?>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</dl>
<?php endif; ?>