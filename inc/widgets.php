<?php
/**
 * Widgets
 */

add_action('widgets_init', 'cs__widgets_init');
function cs__widgets_init(){
	register_sidebar(array(
		'name'          => 'Header',
		'id'            => 'header',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	));

	register_sidebar(array(
		'name'          => 'Footer',
		'id'            => 'footer',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	));
}