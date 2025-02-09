<?php
/**
 * Block / Exhibition details
 */

$dates = get_field('dates');
$location = get_field('location');
$price = get_field('price');
$link = get_field('link');
$button_color = get_field('button_color');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';

$button_modifier = ( isset($button_color) ) ? ' has-background has-'. $button_color .'-background-color' : '';



if ( $dates!='' || $location!='' || $price!='' || !empty($link) ): ?>
	<ul id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-exhibition-details <?= $modifier; ?>">
		<?php if ( $dates!='' ){ ?>
			<li class="block-exhibition-details__item block-exhibition-details__item--dates">
				<time><?= $dates; ?></time>	
			</li>
		<?php } ?>

		<?php if ( $location!='' ){ ?>
			<li class="block-exhibition-details__item block-exhibition-details__item--location">
				<address>
					<p><?= $location; ?></p>
				</address>
			</li>
		<?php } ?>

		<?php if ( $price!='' ){ ?>
			<li class="block-exhibition-details__item block-exhibition-details__item--price">
				<?= $price; ?>
			</li>
		<?php } ?>

		<?php if ( !empty($link) ){ ?>
			<li class="block-exhibition-details__item block-exhibition-details__item--link block-exhibition-details__link-wrap wp-block-button is-style-outline">
				<a class="block-exhibition-details__link wp-block-button__link wp-element-button <?= $button_modifier; ?>" href="<?= $link['url']; ?>"
				   title="<?= $link['title']; ?>"
				   <?= $link['target']!='' ? 'target="'. $link['target'] .'"' : ''; ?>>

					<?= $link['title']; ?>
				</a>
			</li>
		<?php } ?>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</ul>
<?php endif; ?>