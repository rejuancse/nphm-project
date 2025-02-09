<?php
/**
 * Block / Featured slider
 */

$page_background_color = get_field('page_background_color', get_the_ID());
$autoplay = get_field('autoplay');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';


if ( have_rows('blocks') ): ?>
	<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-featured-slider splide" <?= ( isset($autoplay) ) ? 'data-autoplay="'. $autoplay .'"' : ''; ?>>
		<div class="block-featured-slider__track splide__track">
			<ul class="block-featured-slider__list splide__list">
				<?php while ( have_rows('blocks') ): the_row();
					$data = array();
					$data['background_color'] = get_sub_field('background_color');
					$data['image'] = get_sub_field('image');
					$data['heading'] = get_sub_field('heading');
					$data['heading_tag'] = get_sub_field('heading_tag');
					$data['link'] = get_sub_field('link');

					$data['background_color'] = ( $data['background_color']=='default' && $page_background_color!='' ) ? $page_background_color : $data['background_color']; ?>

					<?php if ( $data['image']!='' ){ ?>
						<li class="block-featured-slider__slide splide__slide">
							<?php get_template_part('parts/content/featured-slide/featured-slide', '', array('data' => $data)); ?>
						</li>
					<?php } ?>
				<?php endwhile; ?>
			</ul>
		</div>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</section>
<?php endif; ?>
