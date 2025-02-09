<?php
/**
 * Block / Bio cards
 */

$cards_per_row = get_field('cards_per_row');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';
if ( $cards_per_row==4 ){
	$modifier .= ' grid grid--'. $cards_per_row .' grid--lg-3 grid--md-3 grid--sm-2 grid--xs-2';
} else {
	$modifier .= ' grid grid--'. $cards_per_row;
	$modifier .= ( $cards_per_row>=3 ) ? ' grid--sm-2' : '';
	$modifier .= ' grid--xs-1';
}


if ( have_rows('blocks') ): ?>
	<ul id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-bio-cards <?= $modifier; ?>">
		<?php while ( have_rows('blocks') ): the_row();
			$data = array();
			$data['image'] = get_sub_field('image');
			$data['name'] = get_sub_field('name');
			$data['pronouns'] = get_sub_field('pronouns');
			$data['position'] = get_sub_field('position');
			$data['text'] = get_sub_field('text');
			$data['link'] = get_sub_field('link'); ?>

			<li class="block-bio-cards__item col">
				<?php get_template_part('parts/content/bio-card/bio-card', '', array('data' => $data)); ?>
			</li>
		<?php endwhile; ?>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</ul>
<?php endif; ?>