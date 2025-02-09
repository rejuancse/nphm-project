<?php
/**
 * Block / Bio cards Popup
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
	<ul id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-bio-cards-popup <?= $modifier; ?>">
		<?php
			$index = 1;
			while ( have_rows('blocks') ): the_row();
			$data = array();
			$data['image'] = get_sub_field('image');
			$data['name'] = get_sub_field('name');
			$data['pronouns'] = get_sub_field('pronouns');
			$data['citystate'] = get_sub_field('citystate');
			$data['relationship_to_public_housing'] = get_sub_field('relationship_to_public_housing');
			$data['roles_at_nphm'] = get_sub_field('roles_at_nphm');
			$data['what_identities_are_central_to_you'] = get_sub_field('what_identities_are_central_to_you');
			$data['about_you_answer'] = get_sub_field('about_you_answer');
			$data['link'] = get_sub_field('link');
			$data['index'] = $index;
		?>

			<li class="block-bio-cards__item col <?= 'list-item-'.$index; ?>">
				<?php get_template_part('parts/content/bio-card-popup/bio-card-popup', '', array('data' => $data)); ?>
			</li>
		<?php $index++; endwhile; ?>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</ul>
<?php endif; ?>
