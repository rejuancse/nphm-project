<?php
/**
 * Menu Walker
 */

/*** Header menu Walker ***/
class cs__header_menu_walker extends Walker_Nav_Menu {
	private $curItem;

	// add classes to ul sub-menus
	function start_lvl( &$output, $depth=0, $args=array() ){
		$submenu_text = get_field('submenu_text', $this->curItem);
		$event = get_field('event', $this->curItem);

		// depth dependent classes
		$indent = ($depth>0 ? str_repeat("\t", $depth) : ''); // code indent
		$display_depth = ($depth+1); // because it counts the first submenu as 0
		$classes = array(
			'sub-menu',
			($display_depth%2 ? 'menu-odd' : 'menu-even'),
			($display_depth>=2 ? 'sub-sub-menu' : ''),
			'menu-depth-'. $display_depth
		);
		$class_names = implode(' ', $classes);

		// build html
		$output .= "\n". $indent .'<div class="'. $class_names .'"><div class="sub-menu__container container"><div class="sub-menu__top-container">';
		if ( isset($submenu_text) && $submenu_text!='' ){
			$output .= "\n". '<div class="sub-menu__text-left">'. $submenu_text .'</div>';
		} else if ( isset($event) && !empty($event) ){
			$multi_day = get_field('multi_day', $event);
			$start_date = get_field('start_date', $event);
			$start_time = get_field('start_time', $event);
			$end_time = get_field('end_time', $event);
			if ( $multi_day ){
				$end_date = get_field('end_date', $event);
			}

			$output .= "\n". '<div class="sub-menu__event">';
				$output .= '<p class="sub-menu__event-title wp-block-button is-style-arrow"><a class="wp-block-button__link" href="'. get_permalink($event) .'">'. get_the_title($event) .'</a></p>';

				if ( $multi_day && isset($start_date) && isset($end_date) ){
					$output .= '<time class="sub-menu__event-time">'. date('F j, Y', strtotime($start_date));
					$output .= ( $start_time ) ? ' @ '. $start_time : '';
					$output .= ' - '. date('F j, Y', strtotime($end_date));
					$output .= ( $end_time ) ? ' @ '. $end_time : '';
					$output .= '</time>';
				} else if ( !$multi_day && isset($start_date) ){
					$output .= '<time class="sub-menu__event-time">'. date('l, F j, Y', strtotime($start_date));
					$output .= ( $start_time ) ? ' @ '. $start_time : '';
					$output .= ( $end_time ) ? ' - '. $end_time : '';
					$output .= '</time>';
				}
			$output .= '</div>';
		}
		$output .= '<ul class="sub-menu__list">'. "\n";
	}

	function end_lvl( &$output, $depth=0, $args=array() ){
		$header_navigation = get_field('header_navigation', 'options');

		$output .= "</ul>";
		$output .= "\n". '</div><div class="sub-menu__bottom-container">';
		if ( isset($header_navigation['text_bottom']) ){
			$output .= "\n". '<div class="sub-menu__text-bottom">'. $header_navigation['text_bottom'] .'</div>';
		}
		if ( isset($header_navigation['form']) ){
			$output .= "\n". '<div class="sub-menu__form">'. $header_navigation['form'] .'</div>';
		}
		$output .= '</div></div></div>';
	}

	// add main/sub classes to li's and links
	function start_el( &$output, $item, $depth=0, $args=array(), $current_object_id=0 ){
		global $wp_query;
		$this->curItem = $item;

		$background_color = get_field('background_color', $item);
		$popup_view = get_field('popup_view', $item);
		$navigation_popup = get_field('navigation_popup', 'options');

		$indent = ($depth>0 ? str_repeat("\t", $depth) : ''); // code indent
		// depth dependent classes
		$depth_classes = array(
			($depth==0 ? 'main-menu-item' : 'sub-menu-item'),
			($depth>=2 ? 'sub-sub-menu-item' : ''),
			($depth%2 ? 'menu-item-odd' : 'menu-item-even'),
			'menu-item-depth-'. $depth,
			( isset($background_color) ? 'has-background-'. $background_color : '' ),
			( isset($popup_view) ? 'navigation-popup-'. $popup_view : '' )
		);
		$depth_class_names = esc_attr(implode(' ', $depth_classes));

		// passed classes
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

		// build html
		$output .= $indent .'<li id="menu-item-'. $item->ID .'" class="' . $class_names .' '. $depth_class_names .'" data-content="'. $item->title .'">';

		// link attributes
		$attributes = !empty($item->attr_title) ? ' title="'. esc_attr($item->attr_title) .'"' : '';
		$attributes .= !empty($item->target) ? ' target="'. esc_attr($item->target) .'"' : '';
		$attributes .= !empty($item->xfn) ? ' rel="'. esc_attr($item->xfn) .'"' : '';
		$attributes .= !empty($item->url) ? ' href="'. esc_attr($item->url) .'"' : '';
		$attributes .= ' id="enable_'.$popup_view.'" class="map-point menu-link '. ($depth>0 ? 'sub-menu-link' : 'main-menu-link') .'"';

		$item_output = sprintf('%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s', $args->before, $attributes, $args->link_before, apply_filters('the_title', $item->title, $item->ID), $args->link_after, $args->after);

		// build html
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

		// menupopup
		if( $popup_view ) {
			$output .= '<div class="navmenu-popup-details">
				<div class="overlay"></div>

				<div class="content-wrap">
					<div class="content">
						<div class="close"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
						<path d="M1 21.1716L20.3484 1" stroke="black" stroke-width="2"/>
						<path d="M20.3945 21.1716L1.04615 1" stroke="black" stroke-width="2"/>
					</svg></div>
						<div class="popup-info">'.$navigation_popup['popup_info'].'</div>

						<form action="/">
							<label class="agreecls" for="agreeTerms">
								<input type="checkbox" id="agreeTerms" class="tag-checkbox" required>Agree to terms of use
							</label>
							<span id="requireCls" class="required">Field is required!</span>

							<div class="popupbtn-wrap">
								<div class="block-image-text__link-wrap wp-block-button is-style-arrow" style="text-align: left;">
									<button id="submitBTN" type="submit" class="submit-btn block-image-text__link wp-block-button__link wp-element-button" data-menuUrl="'.$navigation_popup['popup_submit_button_link'].'">Submit</button>
								</div>

								<div class="block-image-text__link-wrap wp-block-button is-style-arrow">
									<a id="learn_more_btn" class="block-image-text__link wp-block-button__link wp-element-button learn-more" href="'.$navigation_popup['popup_learn_more_button_link'].'" title="Learn more" target="_blank">Learn More</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>';
		}
	}
}


/*** Header menu Mobile Walker ***/
class cs__header_menu_mobile_walker extends Walker_Nav_Menu {
	private $curItem;

	// add classes to ul sub-menus
	function start_lvl( &$output, $depth=0, $args=array() ){
		$submenu_text = get_field('submenu_text', $this->curItem);
		$event = get_field('event', $this->curItem);

		// depth dependent classes
        $indent = ($depth>0 ? str_repeat("\t", $depth) : ''); // code indent
        $display_depth = ($depth+1); // because it counts the first submenu as 0
        $classes = array(
            'sub-menu',
            ($display_depth%2 ? 'menu-odd' : 'menu-even'),
            ($display_depth>=2 ? 'sub-sub-menu' : ''),
            'menu-depth-'. $display_depth
        );
        $class_names = implode(' ', $classes);

        // build html
		$output .= "\n". $indent .'<button class="sub-menu-toggle">.</button><div class="'. $class_names .'">';
		if ( isset($submenu_text) && $submenu_text!='' ){
			$output .= "\n". '<div class="sub-menu__text-left">'. $submenu_text .'</div>';
		} else if ( isset($event) && !empty($event) ){
			$multi_day = get_field('multi_day', $event);
			$start_date = get_field('start_date', $event);
			$start_time = get_field('start_time', $event);
			$end_time = get_field('end_time', $event);
			if ( $multi_day ){
				$end_date = get_field('end_date', $event);
			}

			$output .= "\n". '<div class="sub-menu__event">';
				$output .= '<p class="sub-menu__event-title wp-block-button is-style-arrow"><a class="wp-block-button__link" href="'. get_permalink($event) .'">'. get_the_title($event) .'</a></p>';

				if ( $multi_day && isset($start_date) && isset($end_date) ){
					$output .= '<time class="sub-menu__event-time">'. date('F j, Y', strtotime($start_date));
					$output .= ( $start_time ) ? ' @ '. $start_time : '';
					$output .= ' - '. date('F j, Y', strtotime($end_date));
					$output .= ( $end_time ) ? ' @ '. $end_time : '';
					$output .= '</time>';
				} else if ( !$multi_day && isset($start_date) ){
					$output .= '<time class="sub-menu__event-time">'. date('l, F j, Y', strtotime($start_date));
					$output .= ( $start_time ) ? ' @ '. $start_time : '';
					$output .= ( $end_time ) ? ' - '. $end_time : '';
					$output .= '</time>';
				}
			$output .= '</div>';
		}
		$output .= '<ul class="sub-menu__list">'. "\n";
	}

	function end_lvl( &$output, $depth=0, $args=array() ){
		$output .= "</ul>";
		$output .= '</div>';
	}

	// add main/sub classes to li's and links
	function start_el( &$output, $item, $depth=0, $args=array(), $current_object_id=0 ){
		global $wp_query;
		$this->curItem = $item;

		$background_color = get_field('background_color', $item);

        $indent = ($depth>0 ? str_repeat("\t", $depth) : ''); // code indent
        // depth dependent classes
        $depth_classes = array(
            ($depth==0 ? 'main-menu-item' : 'sub-menu-item'),
            ($depth>=2 ? 'sub-sub-menu-item' : ''),
            ($depth%2 ? 'menu-item-odd' : 'menu-item-even'),
            'menu-item-depth-'. $depth,
			( isset($background_color) ? 'has-background-'. $background_color : '' ),
        );
        $depth_class_names = esc_attr(implode(' ', $depth_classes));

        // passed classes
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

        // build html
        $output .= $indent .'<li id="menu-item-'. $item->ID .'" class="' . $class_names .' '. $depth_class_names .'" data-content="'. $item->title .'">';

        // link attributes
        $attributes = !empty($item->attr_title) ? ' title="'. esc_attr($item->attr_title) .'"' : '';
        $attributes .= !empty($item->target) ? ' target="'. esc_attr($item->target) .'"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="'. esc_attr($item->xfn) .'"' : '';
        $attributes .= !empty($item->url) ? ' href="'. esc_attr($item->url) .'"' : '';
        $attributes .= ' class="menu-link '. ($depth>0 ? 'sub-menu-link' : 'main-menu-link') .'"';

        $item_output = sprintf('%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s', $args->before, $attributes, $args->link_before, apply_filters('the_title', $item->title, $item->ID), $args->link_after, $args->after);

        // build html
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}