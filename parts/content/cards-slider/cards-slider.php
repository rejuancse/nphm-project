<?php
/**
 * Content / Highlight card
 */

$data = $args['data'];

$modifier = ( isset($args['modifier']) ) ? $args['modifier'] : '';
$modifier .= ( isset($data['background_color']) ) ? ' has-background-'. $data['background_color'] : '';
$modifier .= ( isset($data['badge_color']) ) ? ' has-badge-'. $data['badge_color'] : '';
$modifier .= ( isset($data['image_height']) ) ? ' has-image-'. $data['image_height'] : '';
$badge_color = get_field('badge_color'); ?>


<?php if ( $data['image']!='' && $data['heading']!='' ): ?>
	<article class="highlight-card <?= $modifier; ?>">
		<figure class="highlight-card__media-wrap">
			<?= wp_get_attachment_image($data['image'], 'medium_large', false, array('class' => 'highlight-card__image')); ?>

			<?php if ( $data['badge']!='' ){ ?>
				<figcaption class="highlight-card__media-caption" style="background: <?= $badge_color; ?>">
					<?= $data['badge']; ?>
				</figcaption>
			<?php } ?>

			<?php if ( !empty($data['link']) ){ ?>
				<a class="highlight-card__media-link" href="<?= $data['link']['url']; ?>"
				   title="<?= $data['link']['title']; ?>"
				   <?= $data['link']['target']!='' ? 'target="'. $data['link']['target'] .'"' : ''; ?>></a>
			<?php } ?>
		</figure>

		<div class="highlight-card__content-wrap">
			<?php if ( $data['category']!='' ){ ?>
				<h6 class="highlight-card__category"><?= $data['category']; ?></h6>
			<?php } ?>

			<h4 class="highlight-card__heading"><?= $data['heading']; ?></h4>

			<?php if ( $data['text']!='' ){ ?>
				<div class="highlight-card__text"><?= $data['text']; ?></div>
			<?php } ?>

			<?php if ( !empty($data['link']) ){ ?>
				<div class="highlight-card__link-wrap wp-block-button is-style-arrow">
					<a class="highlight-card__link wp-block-button__link wp-element-button" href="<?= $data['link']['url']; ?>"
					   title="<?= $data['link']['title']; ?>"
					   <?= $data['link']['target']!='' ? 'target="'. $data['link']['target'] .'"' : ''; ?>>

						<?= $data['link']['title']; ?>
					</a>
				</div>
			<?php } ?>
		</div>
	</article>
<?php endif; ?>
