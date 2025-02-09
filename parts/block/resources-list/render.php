<?php
/**
 * Block / Resources List
 */

$filter_heading = get_field('filter_heading');
$resource_title = get_field('resource_title');
$limited_access_content = get_field('limited_access_content');
$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';
require_once(get_theme_root().'/nphm-chicago/inc/AviaryApi.php');

$aviary_posts = new \WP_Query(array(
    'post_type'             => 'aviary-cpt',
    'posts_per_page'        => -1, // Retrieve all posts
    'ignore_sticky_posts'   => 1,
    'order'                 => 'DESC',
    'tax_query' => array(
        array(
            'taxonomy' => 'aviary-resource-cat',
            'terms' => $limited_access_content,
        ),
    ),
));
?>

<section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-resources-list <?= $modifier; ?>">

    <!-- Resources List -->
    <div class="nphm-resources-list-wrap">
        <div class="resources-list">
            <?php
                if ($aviary_posts->have_posts()) {
                    while ($aviary_posts->have_posts()) {
                        $aviary_posts->the_post();

                        $badge = get_field('badge', get_the_ID());
                        $aviary_resource_id = get_field('aviary_resource_id', get_the_ID());
                        $landing_page_link = get_field('landing_page_link', get_the_ID());

                        $resource = AviaryApi::query()->getResource($aviary_resource_id);

                        $videoUrl = $resource['media_files'][0]['video_url'];
                        $cleanedUrl = preg_replace('/\.mp4.*$/', '.mp4', $videoUrl);
                        $fileExtension = pathinfo($cleanedUrl, PATHINFO_EXTENSION);

                        // Content will showing when video is available.
                        if( $fileExtension === 'mp4' ) { ?>
                            <div class="resource-item">
                                <div class="item-info">
                                    <div class="resource-info">
                                        <div class="content">
                                            <h2><?php echo $resource['title']; ?></h2>
                                        </div>
                                    </div>

                                    <div class="resource-img"
                                        style="background-image: url(<?php echo ( $fileExtension == 'mp4' ) ?
                                        ( !empty($resource['media_files'][0]['thumbnail_url']) ? $resource['media_files'][0]['thumbnail_url'] :
                                        'https://nphmchicagostg.wpenginepowered.com/wp-content/uploads/2024/05/dummy_image.jpg' ) : ''; ?>)">

                                        <?php if( !empty($badge) ) { ?>
                                            <figcaption class="highlight-card__media-caption"><?php echo $badge; ?></figcaption>
                                        <?php } ?>

                                        <div class="resource-video-list <?php echo (count($resource['media_files']) > 1 && $fileExtension === 'mp4' ) ? 'splide' : ''; ?>" role="group">
                                            <?php if( count($resource['media_files']) > 1 && $fileExtension === 'mp4' ) { ?>
                                                <div class="block-video splide__arrows">
                                                    <div class="btn-prev">
                                                        <button class="splide__arrow splide__arrow--prev">Prev</button>
                                                    </div>

                                                    <div class="btn-next">
                                                        <button class="splide__arrow splide__arrow--next">Next</button>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <div class="splide__track">
                                                <ul class="splide__list">
                                                    <?php
                                                    foreach( $resource['media_files'] as $value ) {
                                                        $cleanedVedioUrl = preg_replace('/\.mp4.*$/', '.mp4', $value['video_url']);
                                                        $fileType = pathinfo($cleanedVedioUrl, PATHINFO_EXTENSION); ?>
                                                        <?php if( $fileType === 'mp4' ) { ?>
                                                            <li class="video-item splide__slide">
                                                                <div class="video-wrap">
                                                                    <video class="video-bg"
                                                                        poster='<?php echo $value['thumbnail_url']; ?>'
                                                                        controls muted loop playsinline>
                                                                        <source src="<?php echo $cleanedVedioUrl; ?>" type="video/<?php echo $fileType; ?>">
                                                                    </video>
                                                                </div>
                                                            </li>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }

                    wp_reset_postdata();
                }
            ?>

            <div class="load-more">
                <div class="block-image-text__link-wrap wp-block-button is-style-arrow">
                    <a id="loadMore" class="block-image-text__link wp-block-button__link wp-element-button" href="javascript:void(0)" title="See more">
                        <?php esc_attr_e('See more', 'cr'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
</section>
