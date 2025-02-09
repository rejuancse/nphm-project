<?php
/**
 * Post types
 */

/*** Register custom post types ***/
function cs__register_post_types(){
	$types = array(
		array(
			'slug'	 	 			=> 'event',
			'single' 	 			=> 'Event',
			'plural' 	 			=> 'Events',
			'icon'	 	 			=> 'dashicons-calendar-alt',
			'publicly_queryable'	=> true,
			'has_archive'			=> 'events',
			'hierarchical'			=> true,
			'rewrite'	 			=> array(),
			'taxonomies'			=> array('event_category'),
			'template'				=> array(
				array('core/columns', array(), array(
					array('core/column', array('width' => 33.33), array(
						array('cs/event-details', array())
					)),
					array('core/column', array('width' => 66.66), array(
						array('core/paragraph', array()),
					)),
				)),
				array('core/separator', array()),
				array('cs/header', array('data' => array(
					'heading' => 'Upcoming events',
					'heading_tag' => 'h3'
				))),
				array('cs/posts-cards', array('data' => array(
					'post_type' => 'event',
					'choose_posts' => false,
					'posts_per_page' => 3,
					'cards_per_row' => 3,
					'background_color' => 'default',
					'image_height' => 'default'
				))),
			),
		),
		array(
			'slug'	 	 			=> 'exhibition',
			'single' 	 			=> 'Exhibition',
			'plural' 	 			=> 'Exhibitions',
			'icon'	 	 			=> 'dashicons-format-gallery',
			'publicly_queryable'	=> true,
			'has_archive'			=> 'exhibition',
			'hierarchical'			=> false,
			'rewrite'	 			=> array(),
			'taxonomies'			=> array('exhibition_category'),
			'template'				=> array(
				array('core/columns', array(), array(
					array('core/column', array('width' => 33.33), array(
						array('cs/exhibition-details', array())
					)),
					array('core/column', array('width' => 66.66), array(
						array('core/paragraph', array()),
					)),
				)),
				array('core/separator', array()),
				array('cs/header', array('data' => array(
					'heading' => 'More exhibitions',
					'heading_tag' => 'h3'
				))),
				array('cs/posts-cards', array('data' => array(
					'post_type' => 'exhibition',
					'choose_posts' => false,
					'posts_per_page' => 3,
					'cards_per_row' => 3,
					'background_color' => 'default',
					'image_height' => 'default'
				))),
				array('cs/contact-info', array('data' => array(
					'content_type' => 'text',
					'text' => '<h4>Exhibition Resources</h4><p>Learn more about the exhibition.</p>',
					'cta_title' => 'Discover more as a member<br>Join today',
					'cta_link' => '#'
				))),
			),
		),
		array(
			'slug'	 	 			=> 'program',
			'single' 	 			=> 'Program',
			'plural' 	 			=> 'Programs',
			'icon'	 	 			=> 'dashicons-groups',
			'publicly_queryable'	=> true,
			'has_archive'			=> 'program',
			'hierarchical'			=> true,
			'rewrite'	 			=> array(),
			'taxonomies'			=> array('program_category'),
		)
	);

	foreach ( $types as $type ){
		$slug				= $type['slug'];
		$single				= $type['single'];
		$plural				= $type['plural'];
		$icon				= $type['icon'];
		$publicly_queryable	= $type['publicly_queryable'];
		$has_archive		= $type['has_archive'];
		$hierarchical		= $type['hierarchical'];
		$rewrite			= !empty($type['rewrite']) ? $type['rewrite'] : array('slug' => str_replace('_', '-', $slug));
		$taxonomies			= !empty($type['taxonomies']) ? $type['taxonomies'] : array();
		$template			= !empty($type['template']) ? $type['template'] : array();

		$labels = array_merge(DEFAULT_CPT_LABELS, array(
			'name'			 => _x($plural, 'Post type general name', CSWP),
			'singular_name'	 => _x($single, 'Post type singular name', CSWP),
			'all_items'		 => __('All '.$plural, CSWP),
			'archives'		 => __($single.' archives', 'The post type archive label used in nav menus. Default “Post Archives”', CSWP),
			'menu_name'		 => _x($plural, 'Admin Menu text', CSWP),
			'name_admin_bar' => _x($single, 'Add New on Toolbar', CSWP)
		));

		$args = array_merge(DEFAULT_CPT_ARGS, array(
			'labels'				=> $labels,
			'menu_position'			=> 5,
			'publicly_queryable'	=> $publicly_queryable,
			'has_archive'			=> $has_archive,
			'hierarchical'			=> $hierarchical,
			'rewrite'				=> $rewrite,
			'menu_icon'				=> $icon,
			'taxonomies'			=> $taxonomies,
			'template'				=> $template,
		));

		register_post_type($slug, $args);
	}
}
add_action('init', 'cs__register_post_types');


/*** Register custom taxonomies ***/
function cs__register_taxonomies() {
	$taxonomies = array(
		array(
			'cpt'			=> 'event',
			'slug'			=> 'event_category',
			'single'		=> 'Category',
			'plural'		=> 'Categories',
			'hierarchical'	=> true,
			'rewrite'		=> array('slug' => 'event-category')
		),
		array(
			'cpt'			=> 'exhibition',
			'slug'			=> 'exhibition_category',
			'single'		=> 'Category',
			'plural'		=> 'Categories',
			'hierarchical'	=> true,
			'rewrite'		=> array('slug' => 'exhibition-category')
		),
		array(
			'cpt'			=> 'program',
			'slug'			=> 'program_category',
			'single'		=> 'Category',
			'plural'		=> 'Categories',
			'hierarchical'	=> true,
			'rewrite'		=> array('slug' => 'program-category')
		)
	);

	foreach ( $taxonomies as $taxonomy ){
		$cpt = $taxonomy['cpt'];
		$slug = $taxonomy['slug'];
		$single = $taxonomy['single'];
		$plural = $taxonomy['plural'];
		$hierarchical = $taxonomy['hierarchical'];
		$rewrite = !empty($taxonomy['rewrite']) ? $taxonomy['rewrite'] : array('slug' => str_replace('_', '-', $slug));

		$labels = array(
			'name'				=> _x($plural, 'General name for the taxonomy, usually plural', CSWP),
			'singular_name'		=> _x($single, 'Name for one object of this taxonomy', CSWP),
			'search_items'		=>  __('Search '. $plural, CSWP),
			'all_items'			=> __('All '. $plural, CSWP),
			'parent_item'		=> __('Parent '. $single, CSWP),
			'parent_item_colon'	=> __('Parent '. $single .':', CSWP),
			'edit_item'			=> __('Edit '. $single, CSWP),
			'view_item'			=> __('View '. $single, CSWP),
			'update_item'		=> __('Update '. $single, CSWP),
			'add_new_item'		=> __('Add New '. $single, CSWP)
		);

		$args = array(
			'labels'			=> $labels,
			'public'			=> true,
			'hierarchical'		=> $hierarchical,
			'show_ui'			=> true,
			'show_in_rest'		=> true,
			'show_admin_column'	=> true,
			'rewrite'			=> $rewrite,
			'query_var'			=> true,

		);

		register_taxonomy($slug, array($cpt), $args);
	}
}
add_action('init', 'cs__register_taxonomies', 0);


/*
*	Aviary CPT Custom Post type
* */
function cpt_register_aviary_cpts() {
	/**
	 * Post Type: Aviarys.
	 */
	$labels = array(
		'name'                	=> _x( 'Listen Resources', 'Listen Resources', 'cr' ),
		'singular_name'       	=> _x( 'Listen Resource', 'Listen Resources', 'cr' ),
		'menu_name'           	=> __( 'Listen Resources', 'cr' ),
		'parent_item_colon'   	=> __( 'Parent Listen Resource:', 'cr' ),
		'all_items'           	=> __( 'All Listen Resources', 'cr' ),
		'view_item'           	=> __( 'View Listen Resource', 'cr' ),
		'add_new_item'        	=> __( 'Add New Listen Resource', 'cr' ),
		'add_new'             	=> __( 'New Listen Resource', 'cr' ),
		'edit_item'           	=> __( 'Edit Listen Resource', 'cr' ),
		'update_item'         	=> __( 'Update Listen Resource', 'cr' ),
		'search_items'        	=> __( 'Search Listen Resource', 'cr' ),
		'not_found'           	=> __( 'No article found', 'cr' ),
		'not_found_in_trash'  	=> __( 'No article found in Trash', 'cr' )
	);

	$args = array(
		'labels'             	=> $labels,
		'public'             	=> true,
		'publicly_queryable' 	=> true,
		'show_in_menu'       	=> true,
		'show_in_admin_bar'   	=> true,
		'can_export'          	=> true,
		'has_archive'        	=> false,
		'hierarchical'       	=> false,
		'menu_position'      	=> true,
		'menu_icon'				=> 'dashicons-store',
		"rewrite" 				=> [ "slug" => "listen-resource", "with_front" => true ],
		'supports'           	=> array( 'title' ),
		'show_in_rest' 			=> false,
	);

	register_post_type( "aviary-cpt", $args );
}

add_action( 'init', 'cpt_register_aviary_cpts' );

#View Message When Updated aviary-cpt
function aviary_cpts_update_message( $messages ){
	global $post, $post_ID;

	$message['aviary-cpt'] = array(
		0 => '',
		1 => sprintf( __('updated. <a href="%s">View Aviary</a>', 'cr' ), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.', 'cr' ),
		3 => __('Custom field deleted.', 'cr' ),
		4 => __('updated.', 'cr' ),
		5 => isset($_GET['revision']) ? sprintf( __('restored to revision from %s', 'cr' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('published. <a href="%s">View Aviary</a>', 'cr' ), esc_url( get_permalink($post_ID) ) ),
		7 => __('saved.', 'cr' ),
		8 => sprintf( __('submitted. <a target="_blank" href="%s">Preview Aviary</a>', 'cr' ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Aviary</a>', 'cr' ), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('draft updated. <a target="_blank" href="%s">Preview Aviary</a>', 'cr' ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $message;
}

add_filter( 'post_updated_messages', 'aviary_cpts_update_message' );


# Register Tag Taxonomies
function aviary_cpts_category() {
    $labels = array(
		'name'              	=> _x( 'Categories', 'taxonomy general name', 'ct' ),
		'singular_name'     	=> _x( 'Category', 'taxonomy singular name', 'ct' ),
		'search_items'      	=> __( 'Search Category', 'ct' ),
		'all_items'         	=> __( 'All Category', 'ct' ),
		'parent_item'       	=> __( 'Parent Category', 'ct' ),
		'parent_item_colon' 	=> __( 'Parent Category:', 'ct' ),
		'edit_item'         	=> __( 'Edit Category', 'ct' ),
		'update_item'       	=> __( 'Update Category', 'ct' ),
		'add_new_item'      	=> __( 'Add New Category', 'ct' ),
		'new_item_name'     	=> __( 'New Category Name', 'ct' ),
		'menu_name'         	=> __( 'Category', 'ct' )
	);

    $args = array(
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_in_nav_menus'     => true,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
    );

    register_taxonomy( 'aviary-resource-cat', array( 'aviary-cpt' ), $args );
}

add_action( 'init', 'aviary_cpts_category' );

# Register Tag Taxonomies
function aviary_cpts_tag_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Tags', 'taxonomy general name', 'cr' ),
        'singular_name'              => _x( 'Tag', 'taxonomy singular name', 'cr' ),
        'search_items'               => __( 'Search Tags', 'cr' ),
        'popular_items'              => __( 'Popular Tags', 'cr' ),
        'all_items'                  => __( 'All Tags', 'cr' ),
        'edit_item'                  => __( 'Edit Tag', 'cr' ),
        'update_item'                => __( 'Update Tag', 'cr' ),
        'add_new_item'               => __( 'Add New Tag', 'cr' ),
        'new_item_name'              => __( 'New Tag Name', 'cr' ),
        'separate_items_with_commas' => __( 'Separate tags with commas', 'cr' ),
        'add_or_remove_items'        => __( 'Add or remove tags', 'cr' ),
        'choose_from_most_used'      => __( 'Choose from the most used tags', 'cr' ),
        'menu_name'                  => __( 'Tags', 'cr' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_in_nav_menus'     => true,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
    );

    register_taxonomy( 'aviary-resource-tag', array( 'aviary-cpt' ), $args );
}

add_action( 'init', 'aviary_cpts_tag_taxonomy' );