<?php
define('CSWP', 'cswp');

// Constants
include 'inc/constants.php';

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if ( function_exists('add_theme_support') ){
	add_theme_support('custom-logo', array(
		'height'      => '200',
		'flex-height' => true,
		'flex-width'  => true,
	));
	add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script'));
	add_theme_support('menus');
	add_theme_support('post-thumbnails');
	add_theme_support('responsive-embeds');
	add_theme_support('title-tag');
	add_theme_support('wp-block-styles');
}

add_filter('upload_mimes', 'cs__mime_types');
function cs__mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

add_filter('get_custom_logo', function( $html ){ // Change custom logo class
	$html = str_replace('custom-logo-link', 'logo', $html);
	$html = str_replace('custom-logo', 'logo__image', $html);
	return $html;
});


/*** Register Navigation ***/
register_nav_menus(array(
	'primary-menu' => __('Primary Menu', CSWP),
	'footer-menu' => __('Footer Menu', CSWP),
));


/*** Search ***/
function cs__searchFilter( $query ){
	if ( !is_admin() ) {
		$post_type = 'all';
		if ( isset($_GET) ){
			if ( isset($_GET['t']) ){
				$post_type = $_GET['t'];
			}
		}
		$post_type = ( in_array($post_type, array('page', 'event','program',  'post', 'aviary-cpt')) ) ? $post_type : 'any';

		if ( $query->is_search ){
			$query->set('post_type', $post_type);
			$query->set('orderby', 'relevance');
		};
	}

	return $query;
};
add_filter('pre_get_posts','cs__searchFilter');


/*** Includes ***/
// Theme
require_once 'inc/enqueue.php';
require_once 'inc/helper-functions.php';
require_once 'inc/wordpress-cleanup.php';

// Functionality
include_once 'inc/admin.php';
require_once 'inc/blocks.php';
require_once 'inc/breadcrumbs.php';
require_once 'inc/cpt-event.php';
require_once 'inc/cpt-exhibition.php';
require_once 'inc/menu-walker.php';
require_once 'inc/pagination.php';
require_once 'inc/post-types.php';
require_once 'inc/widgets.php';

// Plugin support
require_once 'inc/acf.php';
require_once 'inc/contact-form-7.php';
