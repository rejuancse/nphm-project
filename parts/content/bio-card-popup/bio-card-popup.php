<?php
/**
 * Content / Bio card Popup
 */

$data = $args['data'];

$modifier = ( isset($args['modifier']) ) ? $args['modifier'] : ''; ?>


<?php if ( $data['image']!='' && $data['name']!='' ): ?>
	<article class="bio-card-popup <?= $modifier; ?>">
		<?php if ( $data['image']!='' ){ ?>
			<figure class="bio-card__media-wrap">
				<?= wp_get_attachment_image($data['image'], 'medium_large', false, array('class' => 'bio-card__image')); ?>
			</figure>
		<?php } ?>

		<div class="bio-card__content-wrap">
            <div class="bio-personal-info">
                <h4 class="bio-card__name">
                    <?= $data['name']; ?>
                </h4>
                <?php if ( $data['pronouns']!='' ){ ?>
                    <span class="bio-card_name_pronouns">(<?= $data['pronouns']; ?>)</span>
                <?php } ?>

                <?php if ( $data['roles_at_nphm']!='' ){ ?>
                    <h5 class="bio-card__position"><?= $data['roles_at_nphm']; ?></h5>
                <?php } ?>
            </div>

			<?php if ( !empty($data['link']) ){ ?>
				<div class="bio-card__link-wrap wp-block-button is-style-arrow">
					<a class="bio-card__link wp-block-button__link wp-element-button" href="<?= $data['link']['url']; ?>"
					   title="<?= $data['link']['title']; ?>"
					   <?= $data['link']['target']!='' ? 'target="'. $data['link']['target'] .'"' : ''; ?>>

						<?= $data['link']['title']; ?>
					</a>
				</div>
			<?php } ?>
			<button class="openPopupBtn" data-popup="popup-<?= $data['index']; ?>">Learn More</button>
		</div>
	</article>

    <!-- Popup Structure -->
    <div id="popup-<?= $data['index']; ?>" class="popup">
        <div class="popup-content">
            <div class="popup-content-wrap">
                <h2 class="popup-content-title">
                    <?= $data['name']; ?>
                    <?php if ( $data['pronouns']!='' ){ ?>
                        <span><?= $data['pronouns']; ?></span>
                    <?php } ?>
                </h2>
                <?php if ( !empty($data['citystate']) ){ ?>
                    <span class="popup-content-city"><?= $data['citystate']; ?></span>
                <?php }?>
                <div class="popup-other-contents-wrap">
                    <div class="image-box">
                        <?php if ( $data['image']!='' ){ ?>
                            <figure class="bio-card__media-wrap">
                                <?= wp_get_attachment_image($data['image'], 'medium_large', false, array('class' => 'bio-card__image')); ?>
                            </figure>
                        <?php } ?>
                    </div>
                    <div class="popup-other--contents">
                        <?php if ( !empty($data['relationship_to_public_housing']) ){ ?>
                            <div class="relationship_to_public_housing"><p><?= $data['relationship_to_public_housing']; ?></p></div>
                        <?php }?>
                        <?php if ( !empty($data['what_identities_are_central_to_you']) ){ ?>
                            <div class="what_identities_are_central_to_you"><p><?= $data['what_identities_are_central_to_you']; ?></p></div>
                        <?php }?>
                        <?php if ( !empty($data['about_you_answer']) ){ ?>
                            <div class="about_you_answer"><p><?= $data['about_you_answer']; ?></p></div>
                        <?php }?>
                    </div>
                </div>
                <div class="popup-content-footer">
                    <p>Photos from our On the Lawn Concert in Millennium Park</p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>