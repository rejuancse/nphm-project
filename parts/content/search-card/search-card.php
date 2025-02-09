<?php
/**
 * Content / Search card
 */

$modifier = ( isset($args['modifier']) ) ? $args['modifier'] : ''; ?>


<article id="post-<?php the_ID(); ?>" <?php post_class('search-card '. $modifier); ?>>
	<div class="search-card__content-wrap">
		<h5 class="search-card__heading">
			<a class="builtin" href="<?php the_permalink(); ?>" title="Go to page: <?= get_the_title(); ?>"><?php the_title(); ?></a>
		</h5>

		<div class="search-card__text">
			<p><?php the_excerpt(); ?></p>
		</div>

		<div class="search-card__link-wrap wp-block-button is-style-outline">
			<a class="search-card__link wp-block-button__link wp-element-button has-plum-background-color has-background" href="<?php the_permalink(); ?>" title="Go to page: <?= get_the_title(); ?>">Go to page</a>
		</div>
	</div>
</article>