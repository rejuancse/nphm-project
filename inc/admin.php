<?php
/**
 * Admin
 */

/*** Admin menu ***/
function cs__custom_menu_order( $menu_order ){
	$new_positions = array(
		'index.php'								=> 1,	// Dashboard
		
		'separator1'							=> 10,	// First separator
		'edit.php?post_type=page'				=> 11,	// Pages
		'edit.php'								=> 12,	// Posts
		'edit.php?post_type=event'				=> 13,	// Events
		'edit.php?post_type=exhibition'			=> 14,	// Exhibitions
		'edit.php?post_type=aviary-cpt'			=> 15,	// Listen Resources
		'edit.php?post_type=program'			=> 16,	// Programs
		'upload.php'							=> 20,	// Media
		'wpcf7'									=> 21,	// Contact Form 7
		'theme-settings'						=> 22,	// ACF: Theme Settings
		
		'separator2'							=> 30,	// Second separator
		'themes.php'							=> 31,	// Appearance
		'plugins.php'							=> 32,	// Plugins
		'users.php'								=> 33,	// Users
		'tools.php'								=> 34,	// Tools
		'options-general.php'					=> 35,	// Settings
		
		'separator-last'						=> 40,	// Last separator
		'edit.php?post_type=acf-field-group'	=> 60,	// ACF
	);
	
	function move_element( &$array, $a, $b ){
		$out = array_splice($array, $a, 1);
		array_splice($array, $b, 0, $out);
	}
	
	foreach ( $new_positions as $value=>$new_index ){
		if ( $current_index=array_search($value, $menu_order) ){
			move_element($menu_order, $current_index, $new_index);
		}
	}

	return $menu_order;
}
add_filter('custom_menu_order', function() { return true; });
add_filter('menu_order', 'cs__custom_menu_order', 10, 1);


/*** Tidy up admin bar ***/
function remove_admin_bar_links(){
	global $wp_admin_bar;

	$wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
	$wp_admin_bar->remove_menu('comments');         // Remove the comments link
	$wp_admin_bar->remove_menu('customize');
	$wp_admin_bar->remove_menu('dashboard');
	$wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
	$wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
	$wp_admin_bar->remove_menu('menus');
	$wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
	$wp_admin_bar->remove_menu('themes');
	$wp_admin_bar->remove_menu('updates');          // Remove the updates link
	$wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );


/*** TinyMCE: add style selector ***/
function cs__mce_add_more_buttons( $buttons ){
	$buttons[] = 'styleselect';
	return $buttons;
}
add_filter('mce_buttons_2', 'cs__mce_add_more_buttons');

function cs__mce_before_init( $settings ){
	$textcolor_map = array(
		'000', 'Black',
		'FFF', 'White',
		'F73F3B', 'Red',
		'FF5E35', 'Orange',
		'FFA490', 'Coral',
		'FFC7BA', 'Peach',
		'452220', 'Brown',
		'C1A097', 'Taupe',
		'E2C8C1', 'Beige',
		'5E1742', 'Plum',
		'E8B6CE', 'Pink',
		'C2D8E5', 'Light blue',
		'61AA99', 'Turquoise',
		'B6DAD2', 'Mint',
		'F4E365', 'Lemon',
		'FBF3BD', 'Light yellow',

		'4B4B4B', 'Dark gray',
		'DBDBDB', 'Medium gray',
		'F5F5F5', 'Light gray',
	);
	$style_formats = array(
		array(
			'title' => 'Inline',
			'items' => array(
				['title' => 'Bold',				'icon' => 'bold',			'format' => 'bold'],
				['title' => 'Italic',			'icon' => 'italic',			'format' => 'italic'],
				['title' => 'Underline',		'icon' => 'underline',		'format' => 'underline'],
				['title' => 'Strikethrough',	'icon' => 'strikethrough',	'format' => 'strikethrough'],
				['title' => 'Superscript',		'icon' => 'superscript',	'format' => 'superscript'],
				['title' => 'Subscript',		'icon' => 'subscript',		'format' => 'subscript'],
				['title' => 'Code',				'icon' => 'code',			'format' => 'code'],
			)
		),
		array(
			'title' => 'Font sizes',
			'items' => array(
				['title' => 'Heading 1',	'selector' => 'p,h1,h2,h3,h4,h5,h6',	'classes' => 'has-heading-1-font-size'],
				['title' => 'Heading 2',	'selector' => 'p,h1,h2,h3,h4,h5,h6',	'classes' => 'has-heading-2-font-size'],
				['title' => 'Heading 3',	'selector' => 'p,h1,h2,h3,h4,h5,h6',	'classes' => 'has-heading-3-font-size'],
				['title' => 'Heading 4',	'selector' => 'p,h1,h2,h3,h4,h5,h6',	'classes' => 'has-heading-4-font-size'],
				['title' => 'Heading 5',	'selector' => 'p,h1,h2,h3,h4,h5,h6',	'classes' => 'has-heading-5-font-size'],
				['title' => 'Heading 6',	'selector' => 'p,h1,h2,h3,h4,h5,h6',	'classes' => 'has-heading-6-font-size'],
				['title' => 'Large',		'selector' => 'p',						'classes' => 'has-large-font-size'],
				['title' => 'Medium',		'selector' => 'p',						'classes' => 'has-medium-font-size'],
				['title' => 'Base',			'selector' => 'p',						'classes' => 'has-base-font-size'],
				['title' => 'Small',		'selector' => 'p',						'classes' => 'has-small-font-size'],
			)
		),
		array(
			'title' => 'Icons',
			'items' => array(
				['title' => 'Clock',		'selector' => 'p',	'classes' => 'has-icon-clock'],
				['title' => 'Envelope',		'selector' => 'p',	'classes' => 'has-icon-envelope'],
				['title' => 'Phone',		'selector' => 'p',	'classes' => 'has-icon-phone'],
			)
		),
		array(
			'title' => 'Buttons',
			'items' => array(
				['title' => 'Black',		'selector' => 'a',	'classes' => 'button button--outline button--foreground'],
				['title' => 'White',		'selector' => 'a',	'classes' => 'button button--outline button--background'],
				['title' => 'Red',			'selector' => 'a',	'classes' => 'button button--outline button--red'],
				['title' => 'Orange',		'selector' => 'a',	'classes' => 'button button--outline button--orange'],
				['title' => 'Coral',		'selector' => 'a',	'classes' => 'button button--outline button--coral'],
				['title' => 'Peach',		'selector' => 'a',	'classes' => 'button button--outline button--peach'],
				['title' => 'Brown',		'selector' => 'a',	'classes' => 'button button--outline button--brown'],
				['title' => 'Taupe',		'selector' => 'a',	'classes' => 'button button--outline button--taupe'],
				['title' => 'Beige',		'selector' => 'a',	'classes' => 'button button--outline button--beige'],
				['title' => 'Plum',			'selector' => 'a',	'classes' => 'button button--outline button--plum'],
				['title' => 'Pink',			'selector' => 'a',	'classes' => 'button button--outline button--pink'],
				['title' => 'Light blue',	'selector' => 'a',	'classes' => 'button button--outline button--light-blue'],
				['title' => 'Turquoise',	'selector' => 'a',	'classes' => 'button button--outline button--turquoise'],
				['title' => 'Mint',			'selector' => 'a',	'classes' => 'button button--outline button--mint'],
				['title' => 'Lemon',		'selector' => 'a',	'classes' => 'button button--outline button--lemon'],
				['title' => 'Light yellow',	'selector' => 'a',	'classes' => 'button button--outline button--light-yellow'],
				['title' => 'Dark gray',	'selector' => 'a',	'classes' => 'button button--outline button--dark-gray'],
				['title' => 'Medium gray',	'selector' => 'a',	'classes' => 'button button--outline button--medium-gray'],
				['title' => 'Light gray',	'selector' => 'a',	'classes' => 'button button--outline button--light-gray'],
			)
		),
	);
	$settings['textcolor_cols'] = 6;
	$settings['textcolor_map'] = json_encode($textcolor_map);
	$settings['style_formats'] = json_encode($style_formats);
	return $settings;
}
add_filter('tiny_mce_before_init', 'cs__mce_before_init');


/*** TinyMCE: remove the Color Picker plugin ***/
function cs__mce_remove_custom_colors( $plugins ){
	foreach ( $plugins as $key=>$plugin_name ){
		if ( $plugin_name==='colorpicker' ){
			unset($plugins[$key]);
			return $plugins;            
		}
	}
	return $plugins;
}
add_filter('tiny_mce_plugins', 'cs__mce_remove_custom_colors');