<?php
/**
 * Block / NPHM Info block
 */

$podcast_season = get_field('podcast_season');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';
$modifier .= ( isset($layout) ) ? ' is-style-'. $layout : '';
$modifier .= ( isset($layout) && $layout=='with-image' ) ? ' has-image-'. $image_position : '';
$modifier .= ( isset($layout) && $layout=='with-text' ) ? ' has-text-'. $text_position : '';
?>

<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-podcast-season <?= $modifier; ?>">
	<div class="wrapper">
		<div class="podcast-tabs tabs">
			<!-- Tab List -->
			<div class="season-btn" role="tablist" aria-label="Podcast season">
				<?php
					$index = '0';
					if( isset($podcast_season) && !empty( $podcast_season ) ) {
						foreach( $podcast_season as $value ) {
							$index += 1;
							if ( $index == '1' ) { ?>
								<button role="tab" aria-selected="true" id="season_<?php echo $index; ?>"><?php echo $value['tab_title']; ?></button>
							<?php } else { ?>
								<button role="tab" aria-selected="false" id="season_<?php echo $index; ?>"><?php echo $value['tab_title']; ?></button>
							<?php }
						} $index++;
					}
				?>
			</div>

			<!-- Tab Descriptions -->
			<?php
				$index = '0';
				if( isset($podcast_season) && !empty( $podcast_season ) ) {
					foreach( $podcast_season as $value ) {
					$index += 1;
					if ( $index == '1' ) { ?>
						<div role="tabpanel" aria-labelledby="season_<?php echo $index; ?>">
							<div class="season-info-wrap">
								<div class="left-side">
									<?php
										if( !empty($value['left_side_description']) ) {
											echo $value['left_side_description'];
										}
									?>
								</div>

								<div class="right-side">
									<?php
										if( isset( $value['right_side_description'] ) && !empty( $value['right_side_description'] ) ) {
											foreach( $value['right_side_description']  as $item ) { ?>
												<?php if( !empty( $item['episode_url'] ) ) { ?>
													<div class="audio-info">
														<iframe style="border-radius:12px" src="<?php echo esc_url($item['episode_url']); ?>&theme=0" width="100%" height="352" frameborder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
													</div>
												<?php } ?>

												<div class="lightweight-accordion">
													<details>
														<?php if( !empty( $item['title'] ) ) { ?>
															<summary class="lightweight-accordion-title"><span><?php echo $item['title']; ?></span></summary>
														<?php } ?>

														<div class="lightweight-accordion-body description">
															<?php if( !empty( $item['descriptions'] ) ) { ?>
																<?php echo $item['descriptions']; ?>
															<?php } ?>
														</div>
													</details>
												</div>
											<?php
											}
										}
									?>
								</div>
							</div>
						</div>
					<?php } else { ?>
						<div role="tabpanel" aria-labelledby="season_<?php echo $index; ?>" hidden>
							<div class="season-info-wrap">
								<div class="left-side">
									<?php
										if( !empty($value['left_side_description']) ) {
											echo $value['left_side_description'];
										}
									?>
								</div>

								<div class="right-side">
									<?php
										if( isset( $value['right_side_description'] ) && !empty( $value['right_side_description'] ) ) {
											foreach( $value['right_side_description']  as $item ) { ?>
												<?php if( !empty( $item['episode_url'] ) ) { ?>
													<div class="audio-info">
														<iframe style="border-radius:12px" src="<?php echo esc_url($item['episode_url']); ?>&theme=0" width="100%" height="352" frameborder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
													</div>
												<?php } ?>

												<div class="lightweight-accordion">
													<details>
														<?php if( !empty( $item['title'] ) ) { ?>
															<summary class="lightweight-accordion-title"><span><?php echo $item['title']; ?></span></summary>
														<?php } ?>

														<div class="lightweight-accordion-body description">
															<?php if( !empty( $item['descriptions'] ) ) { ?>
																<?php echo $item['descriptions']; ?>
															<?php } ?>
														</div>
													</details>
												</div>
											<?php
											}
										}
									?>
								</div>
							</div>
						</div>
						<?php }
					} $index++;
				}
			?>
		</div>
	</div>

	<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
</section>
