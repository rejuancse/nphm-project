<?php
/**
 * Block / Posts cards
 */

$page_background_color = get_field('page_background_color', get_the_ID());
$post_type = get_field('post_type');
$choose_posts = get_field('choose_posts');
$cards_per_row = get_field('cards_per_row');
$background_color = get_field('background_color');
$image_height = get_field('image_height');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$background_color = ( $background_color=='default' && $page_background_color!='' ) ? $page_background_color : $background_color;

$args = array(
	'post_type' => $post_type,
	'post__not_in' => array(get_the_ID())
);
if ( $choose_posts ){
	$args['post__in'] = get_field('posts');
	$args['orderby'] = 'post__in';
} else {
	$category = get_field('category');

	$args['posts_per_page'] = get_field('posts_per_page');

	if ( !empty($category) ){
		if ( $post_type=='event' ){
			$args['tax_query'][] = array(
				'taxonomy' => 'event_category',
				'field' => 'term_id',
				'terms' => $category
			);
		} else if ( $post_type=='exhibition' ){
			$args['tax_query'][] = array(
				'taxonomy' => 'exhibition_category',
				'field' => 'term_id',
				'terms' => $category
			);
		} else if ( $post_type=='program' ){
			$args['tax_query'][] = array(
				'taxonomy' => 'program_category',
				'field' => 'term_id',
				'terms' => $category
			);
		} else {
			$args['tax_query'][] = array(
				'taxonomy' => 'category',
				'field' => 'term_id',
				'terms' => $category
			);
		}
	}
}
$cpt_posts = new WP_Query($args);

$modifier = ( isset($block['className']) ) ? $block['className'] : '';
if ( $cards_per_row==4 ){
	$modifier .= ' grid grid--'. $cards_per_row .' grid--lg-3 grid--md-3 grid--sm-2 grid--xs-2';
} else {
	$modifier .= ' grid grid--'. $cards_per_row;
	$modifier .= ( $cards_per_row>=3 ) ? ' grid--sm-2' : '';
	$modifier .= ' grid--xs-1';
}

$cardModifier = '';
$cardModifier .= ( isset($background_color) ) ? ' has-background has-background-'. $background_color : '';
$cardModifier .= ( isset($image_height) ) ? ' has-image-'. $image_height : '';


if ( $cpt_posts->have_posts() ): ?>
	<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-posts-cards <?= $modifier; ?>">
		<?php while ( $cpt_posts->have_posts() ): $cpt_posts->the_post(); ?>
			<div class="block-posts-cards__item col">
				<?php get_template_part('parts/content/'. $post_type .'-card/'. $post_type .'-card', '', array('modifier' => $cardModifier)); ?>
			</div>
		<?php endwhile; ?>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</section>
<?php endif; wp_reset_query(); ?>