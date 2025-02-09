<?php
/**
 * Content / Exhibition card
 */

$blocks = parse_blocks(get_the_content());

$modifier = ( isset($args['modifier']) ) ? $args['modifier'] : ''; ?>


<article id="post-<?php the_ID(); ?>" <?php post_class('exhibition-card '. $modifier); ?>>
	<?php if ( has_post_thumbnail() ){ ?>
		<figure class="exhibition-card__media-wrap">
			<?= wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'medium_large', false, array('class' => 'exhibition-card__image')); ?>

			<?php if ( has_block('cs/exhibition-details') ){ ?>
				<figcaption class="exhibition-card__media-caption"><time class="exhibition-card__time"><?php cs__getExhibitionDate($blocks, 'cs/exhibition-details'); ?></time></figcaption>
			<?php } ?>

			<a class="exhibition-card__media-link" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a>
		</figure>
	<?php } ?>
	
	<div class="exhibition-card__content-wrap">
		<?php if ( !has_post_thumbnail() && has_block('cs/exhibition-details') ){ ?>
			<time class="exhibition-card__time"><?php cs__getExhibitionDate($blocks, 'cs/exhibition-details'); ?></time>
		<?php } ?>

		<h4 class="exhibition-card__heading">
			<a class="builtin" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h4>

		<div class="exhibition-card__text">
			<p><?php the_excerpt(); ?></p>
		</div>

		<div class="exhibition-card__link-wrap wp-block-button is-style-arrow">
			<a class="exhibition-card__link wp-block-button__link wp-element-button" href="<?php the_permalink(); ?>" title="Read more: <?php the_title(); ?>">Read more</a>
		</div>
	</div>
</article>