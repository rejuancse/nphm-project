<?php
/**
 * Content / Bio card
 */

$data = $args['data'];

$modifier = ( isset($args['modifier']) ) ? $args['modifier'] : ''; ?>


<?php if ( $data['image']!='' && $data['name']!='' ): ?>
	<article class="bio-card <?= $modifier; ?>">
		<?php if ( $data['image']!='' ){ ?>
			<figure class="bio-card__media-wrap">
				<?= wp_get_attachment_image($data['image'], 'medium_large', false, array('class' => 'bio-card__image')); ?>
			</figure>
		<?php } ?>

		<div class="bio-card__content-wrap">
			<h4 class="bio-card__name">
				<?= $data['name']; ?>
			</h4>

			<?php if ( $data['pronouns']!='' ){ ?>
				<p class="bio-card__pronouns"><?= $data['pronouns']; ?></p>	
			<?php } ?>

			<?php if ( $data['position']!='' ){ ?>
				<h5 class="bio-card__position"><?= $data['position']; ?></h5>
			<?php } ?>

			<?php if ( $data['text']!='' ){ ?>
				<div class="bio-card__text"><?= $data['text']; ?></div>
			<?php } ?>

			<?php if ( !empty($data['link']) ){ ?>
				<div class="bio-card__link-wrap wp-block-button is-style-arrow">
					<a class="bio-card__link wp-block-button__link wp-element-button" href="<?= $data['link']['url']; ?>"
					   title="<?= $data['link']['title']; ?>"
					   <?= $data['link']['target']!='' ? 'target="'. $data['link']['target'] .'"' : ''; ?>>

						<?= $data['link']['title']; ?>
					</a>
				</div>
			<?php } ?>
		</div>
	</article>
<?php endif; ?>