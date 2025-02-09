<?php
/**
 * Blocks
 */

/*** Register block categories ***/
function cs__register_block_categories( $categories, $post ){
	return array_merge(
		array(
			array(
				'slug' => 'nphm-blocks',
				'title' => __('NPHM blocks', CSWP),
			),
		),
		$categories
	);
}
add_filter('block_categories_all', 'cs__register_block_categories', 10, 2);


/*** Load Blocks ***/
function cs__load_blocks(){
	$blocks = cs__get_blocks();

	foreach ( $blocks as $block ){
		if ( file_exists(get_template_directory() .'/parts/block/'. $block .'/block.json') ){
			register_block_type( get_template_directory() .'/parts/block/'. $block .'/block.json');

			if ( file_exists(get_template_directory() .'/parts/block/'. $block .'/style.css') ){
				wp_register_style('block-'. $block, get_template_directory_uri() .'/parts/block/'. $block .'/style.css', array(), filemtime(get_template_directory() .'/parts/block/'. $block .'/style.css'));
			}

			// if ( file_exists(get_template_directory() .'/parts/block/'. $block .'/script.js') ){
			// 	wp_enqueue_script('block-'. $block, get_template_directory_uri() .'/parts/block/'. $block .'/script.js', array(), false, filemtime(get_template_directory() .'/parts/block/'. $block .'/script.js'), true);
			// }

			$script_path = get_template_directory() . '/parts/block/' . $block . '/script.js';
			if ( file_exists($script_path) ) {
				$script_url = get_template_directory_uri() . '/parts/block/' . $block . '/script.js';
				$script_version = filemtime($script_path);
				wp_enqueue_script('block-' . $block, $script_url, array(), $script_version, true);
			}

			if ( file_exists(get_template_directory() .'/parts/block/'. $block .'/init.php') ){
				include_once get_template_directory() .'/parts/block/'. $block .'/init.php';
			}
		}
	}
}
add_action('init', 'cs__load_blocks', 5);


/*** Load ACF field groups for blocks ***/
function cs__load_acf_field_group( $paths ){
	$blocks = cs__get_blocks();

	foreach ( $blocks as $block ){
		$paths[] = get_template_directory() .'/parts/block/'. $block;
	}
	return $paths;
}
add_filter('acf/settings/load_json', 'cs__load_acf_field_group');


/*** Get Blocks ***/
function cs__get_blocks(){
	$blocks = scandir(get_template_directory() .'/parts/block/');
	$blocks = array_values(array_diff($blocks, array('..', '.', '.DS_Store', '_base-block')) );
	return $blocks;
}


/*** Render ACF Block ***/
function cs__render_acf_block( $block_name, $attrs=[] ){
	$block = acf_get_block_type( $block_name );
	$content = '';
	$is_preview = false;
	
	foreach ( $attrs as $attr=>$val ){
		$block['data'][$attr] = $val;
	}

	echo acf_rendered_block($block, $content, $is_preview);
}