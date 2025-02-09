<?php
/**
 * Block / Highlight cards
 */

$page_background_color = get_field('page_background_color', get_the_ID());
$heading = get_field('heading');
$link = get_field('link');
$heading_tag = get_field('heading_tag');
$enable_slider = get_field('enable_slider');
$cards_per_row = get_field('cards_per_row');
$image_height = get_field('image_height');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';


if ( have_rows('blocks') ): ?>
	<?php if ( $enable_slider ){ ?>
		<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-highlight-cards splide <?= $modifier; ?>" data-perpage="<?= $cards_per_row;?>">
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
						$data['image'] = get_sub_field('image');
						$data['image_vertical_position'] = get_sub_field('image_vertical_position');
						$data['background_color'] = get_sub_field('background_color');
						$data['badge'] = get_sub_field('badge');
						$data['badge_color'] = get_sub_field('badge_color');
						$data['category'] = get_sub_field('category');
						$data['heading'] = get_sub_field('heading');
						$data['text'] = get_sub_field('text');
						$data['link'] = get_sub_field('link');
						$data['image_height'] = $image_height;
						
						$data['background_color'] = ( $data['background_color']=='default' && $page_background_color!='' ) ? $page_background_color : $data['background_color']; ?>

						<li class="block-highlight-cards__slide splide__slide">
							<?php get_template_part('parts/content/highlight-card/highlight-card', '', array('data' => $data)); ?>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>

			<div class="block-highlight-cards__progress splide__progress">
				<div class="splide__progress-bar"></div>
			</div>

			<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
		</section>

	<?php } else { ?>
		<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-highlight-cards <?= $modifier; ?>">
			<?php if ( $heading!='' || !empty($link) ){ ?>
				<header class="block-highlight-cards__header grid">
					<?php if ( $heading!='' ){ ?>
						<<?= $heading_tag; ?> class="block-highlight-cards__heading col col--8 col--sm-12 col--xs-12"><?= $heading; ?></<?= $heading_tag; ?>>
					<?php } ?>

					<?php if ( !empty($link) ){ ?>
						<div class="block-highlight-cards__link-wrap wp-block-button is-style-arrow col col--4 col--sm-12 col--xs-12">
							<a class="block-highlight-cards__link wp-block-button__link wp-element-button" href="<?= $link['url']; ?>"
							   title="<?= $link['title']; ?>"
							   <?= $link['target']!='' ? 'target="'. $link['target'] .'"' : ''; ?>>

								<?= $link['title']; ?>
							</a>
						</div>
					<?php } ?>
				</header>
			<?php } ?>

			<ul class="block-highlight-cards__list grid grid--<?= $cards_per_row; ?> <?= ( $cards_per_row==3 ) ? 'grid--sm-2' : ''; ?> grid--xs-1">
				<?php while ( have_rows('blocks') ): the_row();
					$data = array();
					$data['image'] = get_sub_field('image');
					$data['image_vertical_position'] = get_sub_field('image_vertical_position');
					$data['background_color'] = get_sub_field('background_color');
					$data['badge'] = get_sub_field('badge');
					$data['badge_color'] = get_sub_field('badge_color');
					$data['category'] = get_sub_field('category');
					$data['heading'] = get_sub_field('heading');
					$data['text'] = get_sub_field('text');
					$data['link'] = get_sub_field('link');
					$data['image_height'] = $image_height;

					$data['background_color'] = ( $data['background_color']=='default' && $page_background_color!='' ) ? $page_background_color : $data['background_color']; ?>

					<li class="block-highlight-cards__slide col">
						<?php get_template_part('parts/content/highlight-card/highlight-card', '', array('data' => $data)); ?>
					</li>
				<?php endwhile; ?>
			</ul>

			<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
		</section>

	<?php } ?>
<?php endif; ?>
