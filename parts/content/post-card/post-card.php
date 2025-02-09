<?php
/**
 * Content / Post card
 */

$modifier = ( isset($args['modifier']) ) ? $args['modifier'] : ''; ?>


<article id="post-<?php the_ID(); ?>" <?php post_class('post-card '. $modifier); ?>>
	<?php if ( has_post_thumbnail() ){ ?>
		<figure class="post-card__media-wrap">
			<?= wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'medium_large', false, array('class' => 'post-card__image')); ?>

			<figcaption class="post-card__media-caption">
				<time class="post-card__time" datetime="<?php the_time('Y-m-d H:m'); ?>"><?php the_time(get_option('date_format')); ?></time>
			</figcaption>

			<a class="post-card__media-link" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a>
		</figure>
	<?php } ?>
	
	<div class="post-card__content-wrap">
		<?php if ( !has_post_thumbnail() ){ ?>
			<time class="post-card__time" datetime="<?php the_time('Y-m-d H:m'); ?>"><?php the_time(get_option('date_format')); ?></time>
		<?php } ?>

		<h4 class="post-card__heading"><?php the_title(); ?></h4>

		<div class="post-card__text">
			<p><?php the_excerpt(); ?></p>
		</div>

		<div class="post-card__link-wrap wp-block-button is-style-arrow">
			<a class="post-card__link wp-block-button__link wp-element-button" href="<?php the_permalink(); ?>" title="Read more: <?php the_title(); ?>">Read more</a>
		</div>
	</div>
</article>