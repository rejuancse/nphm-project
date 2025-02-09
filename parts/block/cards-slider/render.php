<?php
/**
 * Block / Cards Slider
 */

$page_background_color = get_field('page_background_color', get_the_ID());
$heading = get_field('heading');
$link = get_field('link');
$heading_tag = get_field('heading_tag');
$image_height = get_field('image_height');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';

if ( have_rows('blocks') ): ?>

	<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-cards-slider splide <?= $modifier; ?>">
		<header class="block-highlight-cards__header">
			<?php if ( $heading!='' ){ ?>
				<<?= $heading_tag; ?> class="block-highlight-cards__heading"><?= $heading; ?></<?= $heading_tag; ?>>
			<?php } ?>

			<?php if ( !empty($link) ){ ?>
				<div class="block-highlight-cards__link-wrap wp-block-button is-style-arrow col">
					<a class="block-highlight-cards__link wp-block-button__link wp-element-button" href="<?= $link['url']; ?>"
					title="<?= $link['title']; ?>"
					<?= $link['target']!='' ? 'target="'. $link['target'] .'"' : ''; ?>>

						<?= $link['title']; ?>
					</a>
				</div>
			<?php } ?>

			<div class="block-highlight-cards__arrows splide__arrows">
				<button class="splide__arrow splide__arrow--prev">Prev</button>
				<button class="splide__arrow splide__arrow--next">Next</button>
			</div>
		</header>

		<div class="block-highlight-cards__track splide__track">
			<ul class="block-highlight-cards__list splide__list">
				<?php while ( have_rows('blocks') ): the_row();
					$data = array();
					$data['background_color'] = get_sub_field('background_color');
					$data['badge_color'] = get_sub_field('badge_color');
					$data['image'] = get_sub_field('image');
					$data['badge'] = get_sub_field('badge');
					$data['category'] = get_sub_field('category');
					$data['heading'] = get_sub_field('heading');
					$data['text'] = get_sub_field('text');
					$data['link'] = get_sub_field('link');
					$data['image_height'] = $image_height;

					$data['background_color'] = ( $data['background_color']=='default' && $page_background_color!='' ) ? $page_background_color : $data['background_color']; ?>

					<li class="block-highlight-cards__slide splide__slide">
						<?php get_template_part('parts/content/cards-slider/cards-slider', '', array('data' => $data)); ?>
					</li>
				<?php endwhile; ?>
			</ul>
		</div>

		<div class="block-highlight-cards__progress splide__progress">
			<div class="splide__progress-bar"></div>
		</div>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</section>

<?php endif; ?>
