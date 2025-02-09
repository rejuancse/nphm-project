<?php
/**
 * Constants
 */

/*** Post types ***/
$default_cpt_labels = array(
	'add_new'               => __('Add new', CSWP),
	'add_new_item'          => __('Add new post', CSWP),
	'edit_item'             => __('Edit post', CSWP),
	'new_item'              => __('New post', CSWP),
	'view_item'             => __('View post', CSWP),
	'view_items'            => __('View posts', CSWP),
	'search_items'          => __('Search posts', CSWP),
	'not_found'             => __('No posts found.', CSWP),
	'not_found_in_trash'    => __('No posts found in Trash.', CSWP),
	'parent_item_colon'     => __('Parent posts:', CSWP),
	'all_items'             => __('All posts', CSWP),
	'insert_into_item'      => _x('Insert into post', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post)', CSWP),
	'uploaded_to_this_item' => _x('Uploaded to this post', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post)', CSWP),
	'featured_image'        => _x('Featured Image', 'Overrides the “Featured Image” phrase for this post type', CSWP),
	'set_featured_image'    => _x('Set featured image', 'Overrides the “Set featured image” phrase for this post type', CSWP),
	'remove_featured_image' => _x('Remove featured image', 'Overrides the “Remove featured image” phrase for this post type', CSWP),
	'use_featured_image'    => _x('Use as featured image', 'Overrides the “Use as featured image” phrase for this post type', CSWP),
	'filter_items_list'     => _x('Filter posts list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”', CSWP),
	'items_list_navigation' => _x('Posts list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”', CSWP),
	'items_list'            => _x('Posts list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”', CSWP)
);
define('DEFAULT_CPT_LABELS', $default_cpt_labels);

$default_cpt_args = array(
	'labels'              => $default_cpt_labels,
	'description'         => '',
	'public'              => true,
	'hierarchical'        => false,
	'exclude_from_search' => false,
	'publicly_queryable'  => false,
	'show_ui'             => true,
	'show_in_menu'        => true,
	'show_in_rest'        => true,
	'menu_position'       => null,
	'menu_icon'           => null,
	'capability_type'     => 'post',
	'map_meta_cap'        => true,
	'supports'            => array('title', 'editor', 'thumbnail', 'page-attributes', 'excerpt'),
	'taxonomies'          => array(),
	'has_archive'         => false,
	'rewrite'             => true,
	'query_var'           => true,
);
define('DEFAULT_CPT_ARGS', $default_cpt_args);