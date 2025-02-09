<?php
/**
 * ACF Configuration
 */

/*** ACF: register Options page ***/
if ( function_exists('acf_add_options_page') ):
	acf_add_options_page(
		array(
			'page_title'    => __('Theme Settings', CSWP),
			'menu_title'    => __('Theme Settings', CSWP),
			'menu_slug'     => 'theme-settings',
			'capability'    => 'manage_options',
			'position'      => '59',
			'redirect'      => true,
		)
	);
endif;


/*** ACF: add Menu Level rule ***/
add_filter('acf/location/rule_types', 'cs__acf_location_rules_types');
function cs__acf_location_rules_types( $choices ){
	$choices['Menu']['menu_level'] = 'Menu Level';

	return $choices;
}

add_filter('acf/location/rule_values/menu_level', 'cs__acf_location_rule_values_level');
function cs__acf_location_rule_values_level( $choices ){
	$choices[0] = 'First';
	$choices[1] = 'Second';

	return $choices;
}

add_filter('acf/location/rule_match/menu_level', 'cs__acf_location_rule_match_level', 10, 4);
function cs__acf_location_rule_match_level( $match, $rule, $options, $field_group ){
	if ( $rule['operator']=='==' ){
		$match = ( $options['nav_menu_item_depth'] == $rule['value'] );
	}

	return $match;
}


/*** ACF: add default page color ***/
function cs__set_default_page_color( $field ){
	global $pagenow;

	if ( $pagenow=='post-new.php' ){
		if ( isset($_GET['post_type']) && $_GET['post_type']==='event' ){
			$field['value'] = 'pink';
		} else if ( isset($_GET['post_type']) && $_GET['post_type']==='exhibition' ){
			$field['value'] = 'lemon';
		} else if ( isset($_GET['post_type']) && $_GET['post_type']==='program' ){
			$field['value'] = 'mint';
		} else if ( !isset($_GET['post_type']) ){
			$field['value'] = 'peach';
		}
	}

	return $field;
}
add_filter('acf/load_field/name=page_background_color', 'cs__set_default_page_color');