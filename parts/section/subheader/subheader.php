<?php
/**
 * Section / SubHeader
 */

// Default valiues
$layout = 'default';
$add_logo = false;
$image = '';
$image_aspect_ratio = 'original';
$blocks = array();
$logo = '';
$logo_background_color = 'default';
$title = '';
$text_column_1 = '';
$text_column_2 = '';
$background_color = 'light-blue';

// Term
if ( is_tax() || is_category() ){
	$current_term = get_queried_object();

	$title = $current_term->name;
	$text_column_1 = $current_term->description;

	if ( $current_term->taxonomy=='category' ){
		$page_id = get_option('page_for_posts');
		$page_background_color = get_field('page_background_color', $page_id);
		$background_color = ( $page_background_color!='' ) ? $page_background_color : $background_color;
	} else if ( $current_term->taxonomy=='exhibition_category' ){
		$background_color = 'lemon';
	} else if ( $current_term->taxonomy=='program_category' ){
		$background_color = 'mint';
	}

// Archive
} else if ( is_archive() ){
	$current_cpt = get_queried_object();

	$title = $current_cpt->label;

	if ( $current_cpt->name=='exhibition' ){
		$background_color = 'lemon';
	} else if ( $current_cpt->name=='program' ){
		$background_color = 'mint';
	}

} else {
	$page_id = ( is_home() ) ? get_option('page_for_posts') : get_the_ID();

	$page_background_color = get_field('page_background_color', $page_id);
	$layout = get_field('layout', $page_id);
	$add_logo = get_field('add_logo', $page_id);
	$title = get_field('title', $page_id);
	$title = ( $title!='' ) ? $title : get_the_title($page_id);
	$text_column_1 = get_field('text_column_1', $page_id);
	$text_column_2 = get_field('text_column_2', $page_id);
	$background_color = get_field('background_color', $page_id);

	$background_color = ( $page_background_color!='' ) ? $page_background_color : $background_color;

	if ( $layout=='with-image' ){
		$image = get_field('image', $page_id);
		$image_aspect_ratio = get_field('image_aspect_ratio', $page_id);
		$image = ( $image!='' ) ? wp_get_attachment_image($image, '2048x2048', false, array('class' => 'section-hero__image')) : '';
	} else if ( $layout=='with-slider' ){
		$blocks = get_field('blocks', $page_id);
	}

	if ( $add_logo ){
		$logo = get_field('logo', $page_id);
		$logo_background_color = get_field('logo_background_color', $page_id);
	}
}

$modifier = '';
$modifier .= ( isset($background_color) ) ? ' has-background has-background-'. $background_color : '';
$modifier .= ( $add_logo && $logo!='' ) ? ' has-logo' : '';
$modifier .= ( $layout=='default' || ( $image=='' && empty($blocks) ) ) ? ' has-no-image' : '';
$modifier .= ( $layout=='with-image' && $image!='' && $image_aspect_ratio!='' ) ? ' has-image-size-'. $image_aspect_ratio : '';
$modifier .= ( ( $layout=='with-image' || $layout=='with-slider' ) && ( $image!='' || !empty($blocks) ) && ( $text_column_1!='' || $text_column_2 ) ) ? ' has-image-and-text' : ''; ?>


<header class="section-hero section-subheader <?= $modifier; ?>">
	<div class="section-hero__container-top">
		<div class="section-hero__heading-wrap">
			<?php if ( $add_logo && $logo!='' ){
				$logo_background_color = ( $logo_background_color!='' &&  $logo_background_color!='default' ) ? $logo_background_color : $background_color; ?>

				<figure class="section-hero__logo-wrap has-background-<?= $logo_background_color; ?>">
					<?= wp_get_attachment_image($logo, 'medium', false, array('class' => 'section-hero__logo')); ?>
				</figure>
			<?php } ?>

			<?php if ( is_singular('post') ){ ?>
				<time class="section-hero__time" datetime="<?php the_time('Y-m-d H:m'); ?>"><?php the_time(get_option('date_format')); ?></time>
			<?php } ?>

			<h1 class="section-hero__heading"><?= $title; ?></h1>
		</div>

		<?php if ( $layout=='with-image' && $image!='' ){ ?>
			<figure class="section-hero__media-wrap"><?= $image; ?></figure>
		<?php } ?>

		<?php if ( $layout=='with-slider' && !empty($blocks) ){ ?>
			<div class="section-hero__slider splide">
				<div class="section-hero__track splide__track">
					<ul class="section-hero__list splide__list">
						<?php foreach ( $blocks as $item ){
							$item['background_color'] = ( $item['background_color']=='default' && $page_background_color!='' ) ? $page_background_color : $item['background_color']; ?>

							<?php if ( $item['image']!='' ){ ?>
								<li class="section-hero__slide splide__slide">
									<?php get_template_part('parts/content/featured-slide/featured-slide', '', array('data' => $item)); ?>
								</li>
							<?php } ?>
						<?php } ?>
					</ul>
				</div>
			</div>
		<?php } ?>
	</div>

	<?php if ( $text_column_1!='' || $text_column_2!='' ){ ?>
		<div class="section-hero__container-bottom">
			<div class="section-hero__text-wrap grid grid--2 grid--xs-1">
				<?php if ( $text_column_1!='' ){ ?>
					<div class="col"><?= $text_column_1; ?></div>
				<?php } ?>

				<?php if ( $text_column_2!='' ){ ?>
					<div class="col"><?= $text_column_2; ?></div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
</header>