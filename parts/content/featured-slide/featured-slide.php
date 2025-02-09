<?php
/**
 * Content / Features slide
 */

$data = $args['data'];
$data['heading_tag'] = ( $data['heading_tag']!='' ) ? $data['heading_tag'] : 'h3';

$modifier = ( isset($args['modifier']) ) ? $args['modifier'] : '';
$modifier .= ( isset($data['background_color']) ) ? ' has-background-'. $data['background_color'] : ''; ?>

<?php if ( $data['image']!='' ): ?>
	<article class="featured-slide <?= $modifier; ?>" >
		<figure class="featured-slide__media-wrap">
			<?= wp_get_attachment_image($data['image'], '2048x2048', false, array('class' => 'featured-slide__image')); ?>
		</figure>

		<?php if ( $data['heading']!='' || !empty($data['link']) ){ ?>
			<div class="featured-slide__content-wrap grid grid--ai-center">
				<?php if ( $data['heading']!='' ){ ?>
					<<?= $data['heading_tag']; ?> class="featured-slide__heading col col--9 col--sm-12 col--xs-12"><?= $data['heading']; ?></<?= $data['heading_tag']; ?>>
				<?php } ?>

				<?php if ( !empty($data['link']) ){ ?>
					<div class="featured-slide__link-wrap wp-block-button is-style-arrow col col--3 col--sm-12 col--xs-12">
						<a class="featured-slide__link wp-block-button__link wp-element-button" href="<?= $data['link']['url']; ?>"
						title="<?= $data['link']['title']; ?>"
						<?= $data['link']['target']!='' ? 'target="'. $data['link']['target'] .'"' : ''; ?>>

							<?= $data['link']['title']; ?>
						</a>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
	</article>
<?php endif; ?>