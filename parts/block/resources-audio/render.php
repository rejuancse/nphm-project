<?php
/**
 * Block / Resources Audio
 */

$post_object = get_field('listen_resource_title');
$related_interviews_url = get_field('related_interviews_url');
$button_url         = $related_interviews_url ? $related_interviews_url['url'] : '';
$button_text        = $related_interviews_url ? $related_interviews_url['title'] : '';
$button_target      = $related_interviews_url ? $related_interviews_url['target'] : '';

$margin_desktop = get_field('margin_desktop');
$margin_mobile = get_field('margin_mobile');

$modifier = ( isset($block['className']) ) ? $block['className'] : '';

require_once(get_theme_root().'/nphm-chicago/inc/AviaryApi.php');

if ($post_object) {
    $post_id = $post_object->ID;
    $post_content = get_post_field('aviary_resource_id', $post_id);
    $enable_supplemental_file = get_post_field('enable_supplemental_file', $post_id);
    $hero_logo = get_post_field('hero_logo', $post_id);
    $time_stamped_index = get_field('time_stamped_index_values', $post_id);

    $args = array(
        'post_type'           => 'aviary-cpt',
        'posts_per_page'      => 1,
        'ignore_sticky_posts' => 1,
    );

    $query = new WP_Query( $args ); ?>

    <section id="<?= isset($block['anchor']) ? $block['anchor'] : $block['id']; ?>" class="block-resources-audio <?= $modifier; ?>">

        <?php
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ): $query->the_post();
                $resources = AviaryApi::query()->getResource($post_content);
                $title = get_field('title', get_the_ID()); ?>

                <header class="section-hero  has-background has-background-taupe has-logo has-image-size-2-1 has-image-and-text">
                    <div class="section-hero__container-top">
                        <div class="section-hero__heading-wrap">
                            <?php if( !empty( $hero_logo ) ) { ?>
                                <figure class="section-hero__logo-wrap has-background-brown">
                                    <img width="175" height="87" src="<?php echo wp_get_attachment_url($hero_logo); ?>" class="section-hero__logo" alt="Hero Banner" decoding="async">
                                </figure>
                            <?php } ?>

                            <h1 class="section-hero__heading">
                                <?php echo !empty($title) ? $title : $resources['title']; ?>
                            </h1>
                        </div>
                        <figure class="section-hero__media-wrap">
                            <img width="1602" height="717" src="<?php echo (!empty($resources['media_files'][0]['thumbnail_url'])) ? $resources['media_files'][0]['thumbnail_url'] : 'https://nphmchicagostg.wpenginepowered.com/wp-content/uploads/2024/05/dummy_image.jpg'; ?>" class="section-hero__image" alt="Narrator profile image">
                        </figure>
                    </div>
                    <div class="section-hero__container-bottom">
                        <div class="section-hero__text-wrap grid grid--2 grid--xs-1">
                            <div class="col">
                                <?php
                                    # Two line Description will show in here.
                                    if (!empty($resources['description'])) {
                                        $string = $resources['description'];
                                        $firstPeriod = strpos($string, '.');

                                        if ($firstPeriod !== false) {
                                            $secondPeriod = strpos($string, '.', $firstPeriod + 1);
                                            if ($secondPeriod !== false) {
                                                $twoSentences = substr($string, 0, $secondPeriod + 1);
                                            } else {
                                                $twoSentences = $string;
                                            }
                                        } else {
                                            $twoSentences = $string;
                                        }
                                        echo $twoSentences;
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Resources Audio -->
                <div id="resourceAudio" class="nphm-resources-audio-wrap">
                    <div class="resources-audio">
                        <div class="media" style="background-image: url(<?php echo (!empty($resources['media_files'][0]['thumbnail_url'])) ? $resources['media_files'][0]['thumbnail_url'] : 'https://nphmchicagostg.wpenginepowered.com/wp-content/uploads/2024/05/dummy_image.jpg'; ?>) "></div>

                        <div class="audio-content">
                            <div class="timecount-display" style="display: none;">
                                <div id="time_display"></div>
                                <div id="endtime_display"></div>
                            </div>

                            <div class="info">
                                <h2><?php echo $resources['title']; ?></h2>
                                <p>
                                    <strong>Content Warnings: </strong>
                                    <?php
                                        if( !empty( $resources['content_warnings'] ) ) {
                                            $cnt = 0;
                                            $content_warnings = $resources['content_warnings'];
                                            $contentCount = count($content_warnings);
                                            foreach( $content_warnings as $value ) {
                                                $cnt++;
                                                echo ($contentCount == $cnt) ? $value['value'] : $value['value'].', ';
                                            }
                                        } else {
                                            echo 'None';
                                        }
                                    ?>
                                </p>
                                <p><strong>Audio Quality Notes: </strong><?php echo !empty($resources['audio_quality_notes']) ? $resources['audio_quality_notes'] : 'None'; ?></p>
                            </div>

                            <?php
                            $audioUrl = $resources['media_files'][0]['video_url'];
                            $cleanedUrl = preg_replace('/\.(mp3|wav).*$/', '.$1', $audioUrl);
                            $fileExtension = pathinfo($cleanedUrl, PATHINFO_EXTENSION);

                            if( !empty($cleanedUrl) && ($fileExtension == 'mp3' || $fileExtension == 'wav') ) { ?>
                                <div class="block-image-text__link-wrap wp-block-button is-style-arrow">
                                    <div id="audio-cls" class="audio-player" style="visibility: hidden;">
                                        <audio id="player" controls="" controlsList="nodownload">
                                            <source src="<?php echo $cleanedUrl; ?>" type="audio/<?php echo $fileExtension; ?>">
                                        </audio>
                                    </div>

                                    <div class="block-image-text__link wp-block-button__link wp-element-button">
                                        <button id="download_audio" style="display: none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39" fill="none">
                                                <g clip-path="url(#clip0_1341_11701)">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.3356 19.7118C22.3356 21.1981 21.1307 22.403 19.6444 22.403C18.158 22.403 16.9531 21.1981 16.9531 19.7118C16.9531 18.2254 18.158 17.0205 19.6444 17.0205C21.1307 17.0205 22.3356 18.2254 22.3356 19.7118ZM11.57 19.7119C11.57 21.1982 10.3651 22.4031 8.87875 22.4031C7.39241 22.4031 6.1875 21.1982 6.1875 19.7119C6.1875 18.2255 7.39241 17.0206 8.87875 17.0206C10.3651 17.0206 11.57 18.2255 11.57 19.7119ZM30.41 22.403C31.8963 22.403 33.1012 21.1981 33.1012 19.7118C33.1012 18.2254 31.8963 17.0205 30.41 17.0205C28.9237 17.0205 27.7187 18.2254 27.7187 19.7118C27.7187 21.1981 28.9237 22.403 30.41 22.403Z" fill="white"/>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_1341_11701">
                                                    <rect width="37.6775" height="37.6775" fill="white" transform="translate(0.804688 0.873047)"/>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </button>

                                        <button id="play_audio">
                                            <svg class="play" width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="Property 1=Play_L">
                                                    <path id="Subtract" fill-rule="evenodd" clip-rule="evenodd" d="M24 44C35.0457 44 44 35.0457 44 24C44 12.9543 35.0457 4 24 4C12.9543 4 4 12.9543 4 24C4 35.0457 12.9543 44 24 44ZM18.5 15.1262L33.5 23.1933C34.1667 23.5518 34.1667 24.4482 33.5 24.8067L18.5 32.8738C17.8333 33.2323 17 32.7842 17 32.0671V15.9329C17 15.2158 17.8333 14.7677 18.5 15.1262Z" fill="white"/>
                                                </g>
                                            </svg>

                                            <svg class="stop" width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="Property 1=Pause_L">
                                                <path id="Subtract" fill-rule="evenodd" clip-rule="evenodd" d="M44 24C44 35.0457 35.0457 44 24 44C12.9543 44 4 35.0457 4 24C4 12.9543 12.9543 4 24 4C35.0457 4 44 12.9543 44 24ZM17 16C17 15.4477 17.4477 15 18 15H21C21.5523 15 22 15.4477 22 16V32C22 32.5523 21.5523 33 21 33H18C17.4477 33 17 32.5523 17 32V16ZM27 15C26.4477 15 26 15.4477 26 16V32C26 32.5523 26.4477 33 27 33H30C30.5523 33 31 32.5523 31 32V16C31 15.4477 30.5523 15 30 15H27Z" fill="white"/>
                                                </g>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="resources-footer-wrap">
                        <!-- Tags -->
                        <div class="resource-tag">
                            <h2>At a Glance</h2>

                            <!-- Public Housing Complexes -->
                            <?php if( !empty( $resources['public_housing_complexes'] ) ) { ?>
                                <p>
                                    <strong>Public Housing Residency: </strong>
                                    <?php
                                        $cnt = 0;
                                        $public_housing_complexes = $resources['public_housing_complexes'];
                                        $houseCount = count($public_housing_complexes);
                                        foreach( $public_housing_complexes as $value ) {
                                            $cnt++;
                                            echo ($houseCount == $cnt) ? $value['value'] : $value['value'].', ';
                                        }
                                    ?>
                                </p>
                            <?php } ?>

                            <!-- Themes -->
                            <p>
                                <strong>Themes: </strong>
                                <?php
                                if( !empty( $resources['themes'] ) ) {
                                        $cnt = 0;
                                        $themes = $resources['themes'];
                                        $themeCount = count($themes);
                                        foreach( $themes as $value ) {
                                            $cnt++;
                                            echo ($themeCount == $cnt) ? $value['value'] : $value['value'].', ';
                                        }
                                } else {
                                    echo 'None';
                                } ?>
                            </p>

                            <!-- Content Warnings -->
                            <p>
                                <strong>Content Warnings: </strong>
                                <?php
                                    if( !empty( $resources['content_warnings'] ) ) {
                                        $cnt = 0;
                                        $content_warnings = $resources['content_warnings'];
                                        $contentCount = count($content_warnings);
                                        foreach( $content_warnings as $value ) {
                                            $cnt++;
                                            echo ($contentCount == $cnt) ? $value['value'] : $value['value'].', ';
                                        }
                                    } else {
                                        echo 'None';
                                    }
                                ?>
                            </p>

                            <!-- primary_time_period -->
                            <p>
                                <strong>Primary time periods: </strong>
                                <?php if( !empty( $resources['coverage'][0]['value'] ) ) { ?>
                                    <?php
                                        echo $resources['coverage'][0]['value']
                                        // echo $time_period = $resources['primary_time_period'];
                                    ?>
                                <?php } else {
                                    echo 'None';
                                } ?>
                            </p>

                            <!-- Primary Locations -->
                            <p>
                                <strong>Primary locations: </strong>
                                <?php
                                    if (!empty($resources['coverage'])) {
                                        $coverage = $resources['coverage'];
                                        $locationCount = count($coverage);

                                        $cnt = 0;
                                        foreach ($coverage as $key => $value) {
                                            if ($value['vocabulary'] === 'spatial (locations)') {
                                                if ($cnt > 0) {
                                                    echo ', ';
                                                }
                                                echo $value['value'];
                                                $cnt++;
                                            }
                                        }
                                    } else {
                                        echo 'None';
                                    }
                                ?>
                            </p>

                            <!-- Keywords -->
                            <p class="keywords">
                                <strong>Keywords: </strong>
                                <?php
                                if( !empty( $resources['keywords'] ) ) {
                                        $cnt = 0;
                                        $keywords = $resources['keywords'];
                                        $keywordCount = count($keywords);
                                        foreach( $keywords as $value ) {
                                            $cnt++;
                                            echo ($keywordCount == $cnt) ? $value['value'] : $value['value'].', ';
                                        }
                                } else {
                                    echo 'None';
                                } ?>
                            </p>
                        </div>

                        <!-- FAQ -->
                        <div class="faq">
                            <h2>Descriptive Context</h2>

                            <div class="lightweight-accordion">
                                <details>
                                    <summary class="lightweight-accordion-title"><span>Interview Summary</span></summary>
                                    <div class="lightweight-accordion-body description">
                                        <!-- Content Warnings -->
                                        <p>
                                            <strong>Content Warnings: </strong>
                                            <?php
                                                if( !empty( $resources['content_warnings'] ) ) {
                                                    $cnt = 0;
                                                    $content_warnings = $resources['content_warnings'];
                                                    $contentCount = count($content_warnings);
                                                    foreach( $content_warnings as $value ) {
                                                        $cnt++;
                                                        echo ($contentCount == $cnt) ? $value['value'] : $value['value'].', ';
                                                    }
                                                } else {
                                                    echo 'None';
                                                }
                                            ?>
                                        </p>

                                        <?php if( !empty( $resources['description'] ) ) {
                                            echo $resources['description'];
                                        } else {
                                            echo '<p>None</p>';
                                        }  ?>
                                    </div>
                                </details>
                            </div>

                            <div class="lightweight-accordion">
                                <details>
                                    <summary class="lightweight-accordion-title"><span>About the Narrator</span></summary>
                                    <div class="lightweight-accordion-body">
                                        <p class="info-wrap"><strong>Narrator Full Name:</strong> <?php echo $resources['title']; ?></p>

                                        <p class="info-wrap">
                                            <strong>Narrator pronouns:</strong>
                                            <?php if( $resources['identity_marker'] ) { ?>
                                                <?php echo $resources['identity_marker']; ?>
                                            <?php } else {
                                                echo 'None';
                                            } ?>
                                        </p>

                                        <p class="info-wrap">
                                            <strong>Refer to as:</strong>
                                            <?php
                                                if( $resources['refer_as'] ) { ?>
                                                    <?php echo $resources['refer_as']; ?>
                                                <?php } else {
                                                    echo 'None';
                                                }
                                            ?>
                                        </p>

                                        <p class="info-wrap">
                                            <strong>Self-identified race and/or ethnicity: </strong>
                                            <?php if( !empty( $resources['self_identified_race'] ) ) { ?>
                                                <?php echo $self_identified_race = $resources['self_identified_race']; ?>
                                            <?php } else {
                                                echo 'None';
                                            } ?>
                                        </p>

                                        <!-- biographical_context -->
                                        <div class="info-wrap">
                                            <strong>Biographical Context: </strong>

                                            <div class="context">
                                                <?php if( !empty( $resources['biographical_context'] ) ) { ?>
                                                    <?php echo $resources['biographical_context']; ?>
                                                <?php } else {
                                                    echo 'None';
                                                } ?>
                                            </div>
                                        </div>

                                        <!-- Life Dates -->
                                        <div class="info-wrap">
                                            <strong>Life Dates: </strong>
                                            <?php
                                            if( !empty( $resources['life_dates'] ) ) {
                                                    $cnt = 0;
                                                    $life_dates = $resources['life_dates'];
                                                    $dateCount = count($life_dates); ?>

                                                    <ul>
                                                        <?php
                                                            foreach( $life_dates as $value ) {
                                                                $cnt++;
                                                                echo '<li>';
                                                                echo ($dateCount == $cnt) ? ('<span>'.$value['vocabulary'].'</span>'.': '.$value['value']) : ('<span>'.$value['vocabulary'].'</span>'.': '.$value['value']).', ';
                                                                echo '</li>';
                                                            }
                                                        ?>
                                                    </ul>
                                                <?php
                                            } else {
                                                echo 'None';
                                            } ?>
                                        </div>
                                    </div>
                                </details>
                            </div>

                            <div class="lightweight-accordion">
                                <details>
                                    <summary class="lightweight-accordion-title"><span>About the Interview</span></summary>
                                    <div class="lightweight-accordion-body">
                                        <!-- Interviewer -->
                                        <p class="info-wrap">
                                            <strong>Interviewer: </strong>
                                            <?php
                                                if (!empty($resources['interviewer'])) {
                                                    $interviewers = [];
                                                    foreach ($resources['interviewer'] as $value) {
                                                        if ($value['vocabulary'] === 'Interviewer') {
                                                            $interviewers[] = $value['value'];
                                                        }
                                                    }
                                                    echo !empty($interviewers) ? implode(', ', $interviewers) : 'None';
                                                } else {
                                                    echo 'None';
                                                }
                                            ?>

                                        </p>

                                        <!-- Date of Interview -->
                                        <p class="info-wrap">
                                            <strong>Date of Interview: </strong>
                                            <?php
                                                if( !empty( $resources['interview_date'] ) ) {
                                                    echo $resources['interview_date'][0]['value'];
                                                } else {
                                                    echo 'None';
                                                }
                                            ?>
                                        </p>

                                        <!-- Method of Interview -->
                                        <p class="info-wrap">
                                            <strong>Method of Interview: </strong>
                                            <?php
                                                if( !empty( $resources['method_of_interview'] ) ) {
                                                    $cnt = 0;
                                                    $method_of_interview = $resources['method_of_interview'];
                                                    $interviewCount = count($method_of_interview);
                                                    foreach( $method_of_interview as $value ) {
                                                        $cnt++;
                                                        echo ($interviewCount == $cnt) ? $value['value'] : $value['value'].', ';
                                                    }
                                                } else {
                                                    echo 'None';
                                                }
                                            ?>
                                        </p>

                                        <!-- Location of Interview -->
                                        <p class="info-wrap">
                                            <strong>Location of Interview: </strong>
                                            <?php
                                                if( !empty( $resources['primary_locations'] ) ) {
                                                    $cnt = 0;
                                                    $primary_locations = $resources['primary_locations'];
                                                    $locationCount = count($primary_locations);
                                                    foreach( $primary_locations as $value ) {
                                                        $cnt++;
                                                        echo ($locationCount == $cnt) ? $value['value'] : $value['value'].', ';
                                                    }
                                                } else {
                                                    echo 'None';
                                                }
                                            ?>
                                        </p>

                                        <!-- Language -->
                                        <p class="info-wrap">
                                            <strong>Language: </strong>
                                            <?php
                                                if( !empty( $resources['language'] ) ) {
                                                    $cnt = 0;
                                                    $language = $resources['language'];
                                                    $interviewCount = count($language);
                                                    foreach( $language as $value ) {
                                                        $cnt++;
                                                        echo ($interviewCount == $cnt) ? $value['value'] : $value['value'].', ';
                                                    }
                                                } else {
                                                    echo 'None';
                                                }
                                            ?>
                                        </p>

                                        <!-- Duration -->
                                        <p class="info-wrap">
                                            <strong>Duration: </strong>
                                            <?php
                                                if( !empty( $resources['interview_duration'] ) ) {
                                                    $interview_duration = $resources['interview_duration'];
                                                    // $interviewCount = count($interview_duration);
                                                    foreach( $interview_duration as $value ) {
                                                        $total_seconds = $value['value'];
                                                        $hours = floor($total_seconds / 3600);
                                                        $minutes = floor(($total_seconds % 3600) / 60);
                                                        $seconds = $total_seconds % 60;
                                                        $timecode = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
                                                        echo $timecode;
                                                    }
                                                } else {
                                                    echo 'None';
                                                }
                                            ?>
                                        </p>

                                        <!-- Formats Available -->
                                        <p class="info-wrap">
                                            <strong>Formats Available: </strong>
                                            <?php
                                                if( !empty( $resources['format'] ) ) {
                                                    $cnt = 0;
                                                    $format = $resources['format'];
                                                    $interviewCount = count($format);
                                                    foreach( $format as $value ) {
                                                        $cnt++;
                                                        echo ($interviewCount == $cnt) ? $value['value'] : $value['value'].', ';
                                                    }
                                                } else {
                                                    echo 'None';
                                                }
                                            ?>
                                        </p>

                                        <!-- Audio Quality and other notes -->
                                        <p class="info-wrap">
                                            <strong>Audio Quality and other notes: </strong>
                                            <?php
                                                if( !empty( $resources['audio_quality_notes'] ) ) {
                                                    echo $resources['audio_quality_notes'];
                                                } else {
                                                    echo 'None';
                                                }
                                            ?>
                                        </p>

                                        <!-- Post-Production by -->
                                        <p class="info-wrap">
                                            <strong>Post-Production by: </strong>
                                            <?php
                                                if( !empty( $resources['interviewer'] ) ) {
                                                    $cnt = 0;
                                                    $interviewer = $resources['interviewer'];
                                                    $interviewCount = count($interviewer);
                                                    foreach( $interviewer as $value ) {
                                                        $cnt++;
                                                        if($value['vocabulary'] === 'Post-Production by') {
                                                            echo ($interviewCount == $cnt) ? $value['value'] : $value['value'].', ';
                                                        }
                                                    }
                                                } else {
                                                    echo 'None';
                                                }
                                            ?>
                                        </p>

                                        <!-- Contextual Information Last Updated -->
                                        <p class="info-wrap">
                                            <strong>Contextual Information Last Updated:</strong>
                                            <?php
                                               if (!empty($resources['interview_date'])) {
                                                    if (isset($resources['interview_date'][1])) {
                                                        echo $resources['interview_date'][1]['value'];
                                                    } else {
                                                        echo 'None';
                                                    }
                                                } else {
                                                    echo 'None';
                                                }
                                            ?>
                                        </p>
                                    </div>
                                </details>
                            </div>

                            <div class="lightweight-accordion">
                                <details>
                                    <summary class="lightweight-accordion-title"><span>Time-Stamped Index</span></summary>
                                    <div class="lightweight-accordion-body">
                                        <?php
                                            if( !empty($time_stamped_index) ) {
                                                foreach( $time_stamped_index as $value ) {
                                                    // Define the timecode
                                                    $timecode = $value['time'];
                                                    list($hours, $minutes, $seconds) = sscanf($timecode, "%d:%d:%d");
                                                    $total_seconds = $hours * 3600 + $minutes * 60 + $seconds;  ?>

                                                    <div class="timestamp">
                                                        <div class="time">
                                                            <strong><a class="play-timecode" href="#resourceAudio" data-timecode="<?php echo $total_seconds; ?>"><?php echo $value['time']; ?></a></strong>
                                                        </div>

                                                        <div class="time-stamp-intro">
                                                            <a class="play-timecode" href="#resourceAudio" data-timecode="<?php echo $total_seconds; ?>"><?php echo $value['title']; ?></a>
                                                            <?php echo $value['descriptions']; ?>
                                                        </div>
                                                    </div>

                                                <?php }
                                            } else {
                                                echo '<p>No index available for this file.</p>';
                                            }
                                        ?>
                                    </div>
                                </details>
                            </div>

                            <div class="lightweight-accordion">
                                <details>
                                    <summary class="lightweight-accordion-title"><span>Access and Use Guidelines</span></summary>
                                    <div class="lightweight-accordion-body">
                                        <!-- access_level -->
                                        <p class="preferred_citation" style="text-transform: capitalize;">
                                            <strong>Access Level: </strong>
                                            <?php if( !empty( $resources['access_level'] ) ) { ?>
                                            <?php echo $access_level = $resources['access_level']; ?>
                                            <?php } else {
                                                echo 'None';
                                            } ?>
                                        </p>

                                        <!-- Rights Overview -->
                                        <div class="preferred_citation mb-40">
                                            <strong>Rights Overview: </strong>
                                            <div class="info">
                                                <?php if( !empty( $resources['rights_statement'] ) ) {
                                                    echo $resources['rights_statement'];
                                                } else {
                                                    echo 'None';
                                                } ?>
                                            </div>
                                        </div>

                                        <!-- Citation Guidelines -->
                                        <div class="preferred_citation">
                                            <strong>Citation Guidelines: </strong>
                                            <div class="info">
                                                <?php if( !empty( $resources['preferred_citation'] ) ) { ?>
                                                    <?php
                                                        foreach($resources['preferred_citation'] as $value) {
                                                            echo $value['value'];
                                                        }
                                                    ?>
                                                <?php } else {
                                                    echo 'None';
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                </details>
                            </div>

                            <div class="lightweight-accordion">
                                <details>
                                    <summary class="lightweight-accordion-title"><span>Transcript and Supplemental Attachments</span></summary>
                                    <div class="lightweight-accordion-body pdf-file-list-wrap">
                                        <?php
                                            if( !empty($resources['page_meta']['supplemental_files']) ) {
                                                foreach($resources['page_meta']['supplemental_files'] as $value) {
                                                    $cleanedUrl = preg_replace('/\.pdf.*$/', '.pdf', $value);
                                                    $fileExtension = pathinfo($cleanedUrl, PATHINFO_EXTENSION); ?>
                                                    <?php if( $fileExtension === 'pdf' ) { ?>
                                                        <div class="pdf-file-list">
                                                            <iframe src="<?php echo $value; ?>" title="SOME_TITLE" width="100%" height="400"></iframe>

                                                            <?php if( $enable_supplemental_file ) { ?>
                                                                <div class="wp-block-button is-style-outline dw-file"><a class="wp-block-button__link has-orange-background-color has-background wp-element-button" href="<?php echo esc_url($value); ?>" target="_blank">Download PDF</a></div>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } ?>
                                                <?php
                                                }
                                            } else {
                                                echo 'None';
                                            }
                                        ?>
                                    </div>
                                </details>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endwhile;

            wp_reset_postdata();
        } ?>

        <?php cs__set_block_styles($block['id'], $margin_desktop, $margin_mobile); ?>
    </section>

    <?php
    /**
     * Related Post
     */
    $aviary = AviaryApi::query();
    $resource = $aviary->getResource($post_content);
    $relatedPost = $aviary->listRelatedResources($resource);

    if( isset($relatedPost) && !empty( $relatedPost ) ) { ?>
        <div class="default-page aviary-related-post">
            <hr class="wp-block-separator has-alpha-channel-opacity">

            <section class="block-header  grid">
                <h2 class="block-header__heading col col--8 col--sm-12 col--xs-12">Related Interviews</h2>
                <div class="block-header__link-wrap wp-block-button is-style-arrow col col--4 col--sm-12 col--xs-12">
                    <?php if( !empty( $button_url ) ) { ?>
                        <a class="block-header__link wp-block-button__link wp-element-button" href="<?= esc_url($button_url); ?>" title="More Interviews" target="<?= $button_target ?>" target="<?= $button_target ?>">More Interviews</a>
                    <?php } ?>
                </div>
            </section>

            <section class="block-highlight-cards">
                <ul class="block-highlight-cards__list grid grid--3 grid--sm-2 grid--xs-1">
                    <?php foreach( $relatedPost as $value ) { ?>
                        <li class="block-highlight-cards__slide col">
                            <article class="highlight-card  has-background-taupe has-badge-pink has-image-default has-image-position-center">
                                <figure class="highlight-card__media-wrap">
                                    <img decoding="async" width="634" height="696" src="<?php echo (!empty($value['media_files'][0]['thumbnail_url'])) ? $value['media_files'][0]['thumbnail_url'] : 'https://nphmchicagostg.wpenginepowered.com/wp-content/uploads/2024/05/dummy_image.jpg'; ?>" class="highlight-card__image" alt="Narrator profile image">
                                </figure>

                                <div class="highlight-card__content-wrap">
                                    <h4 class="highlight-card__heading"><?php echo $value['title']; ?></h4>
                                    <div class="highlight-card__link-wrap wp-block-button is-style-arrow">
                                        <a class="highlight-card__link wp-block-button__link wp-element-button" href="<?php echo $value['page_meta']['page_link']; ?>" title="Meet All Advisors & Educators">Listen to Their Story</a>
                                    </div>
                                </div>
                            </article>
                        </li>
                    <?php } ?>
                </ul>
            </section>
        </div>
        <?php
    } else { ?>
        <div class="default-page container aviary-related-post">
            <h3>No related posts found!</h3>
        </div>
    <?php }  ?>
<?php } ?>
