<?php
/**
 * Content / Program card
 */

$post_terms = get_the_terms(get_the_ID(), 'program_category');

$modifier = ( isset($args['modifier']) ) ? $args['modifier'] : ''; ?>


<article id="post-<?php the_ID(); ?>" <?php post_class('program-card '. $modifier); ?>>
	<?php if ( has_post_thumbnail() ){ ?>
		<figure class="program-card__media-wrap">
			<?= wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'medium_large', false, array('class' => 'program-card__image')); ?>

			<?php if ( !empty($post_terms) ){ ?>
				<figcaption class="program-card__media-caption">
					<?php $i=0; foreach ( $post_terms as $term ){
						echo $i>0 ? ', '. $term->name : $term->name;	
					$i++; } ?>
				</figcaption>
			<?php } ?>

			<a class="program-card__media-link" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a>
		</figure>
	<?php } ?>
	
	<div class="program-card__content-wrap">
		<?php if ( !has_post_thumbnail() && !empty($post_terms) ){ ?>
			<p class="program-card__terms">
				<?php $i=0; foreach ( $post_terms as $term ){
					echo $i>0 ? ', '. $term->name : $term->name;	
				$i++; } ?>
			</p>
		<?php } ?>

		<h6 class="program-card__post-type">Program</h6>

		<h4 class="program-card__heading">
			<a class="builtin" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h4>

		<div class="program-card__text">
			<p><?php the_excerpt(); ?></p>
		</div>

		<div class="program-card__link-wrap wp-block-button is-style-arrow">
			<a class="program-card__link wp-block-button__link wp-element-button" href="<?php the_permalink(); ?>" title="Join our program: <?php the_title(); ?>">Join our program</a>
		</div>
	</div>
</article>