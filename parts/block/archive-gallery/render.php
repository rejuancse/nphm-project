<?php
/**
 * Block / Masonry gallery
 */


$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$headline = get_field('headline');
$media_gallery = get_field('media_gallery');
$archive_logo = get_field('archive_logo');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';
?>

<section>
	<div id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="publich_oral_history__header <?= $modifier; ?>">

		<h1><?= $headline; ?></h1>

		<div class="photo-gallery">
			<?php
			$index = 0;
			foreach($media_gallery as $value) {
				$index = $index + 1; ?>
				<img class="photo photo__<?php echo $index; ?>" src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
			<?php } $index++; ?>

			<div class="oh-archive-logo">
				<img class="photo photo__six" src="<?php echo $archive_logo['url']; ?>" alt="<?php echo $archive_logo['alt']; ?>">
			</div>
		</div>

		<?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
	</div>
</section>
