<?php
/**
 * CPT Events
 */


/*** Get event date ***/
function cs__getEventDate( $post_id, $type='', $tag=false ){
	$html_output = '';

	$multi_day = get_field('multi_day', $post_id);
	$start_date = get_field('start_date', $post_id);
	$start_date = ( $start_date!='' ) ? strtotime($start_date) : '';
	if ( $multi_day ){
		$end_date = get_field('end_date', $post_id);
		$end_date = ( $end_date!='' ) ? strtotime($end_date) : '';
	}

	$html_output .= ( $tag ) ? '<time datetime="'. date('Y-m-d', $start_date) .'">' : '';

	if ( $type=='formatted' ){
		if ( $multi_day && isset($start_date) && isset($end_date) ){
			if ( date('M', $start_date)==date('M', $end_date) && date('Y', $start_date)==date('Y', $end_date) ){
				$html_output .= date('M', $start_date) .' <br><span>'. date('j', $start_date) .'-'. date('j', $end_date) .'</span> <br>'. date('Y', $start_date);
			} else if ( date('Y', $start_date)==date('Y', $end_date) ){
				$html_output .= date('M', $start_date) .' <span>'. date('j', $start_date) .'</span> - <br>'. date('M', $end_date) .' <span>'. date('j', $end_date) .'</span> '. date('Y', $start_date);
			} else {
				$html_output .= date('M', $start_date) .' <span>'. date('j', $start_date) .'</span> '. date('Y', $start_date) .' - <br>'. date('M', $end_date) .' <span>'. date('j', $end_date) .'</span> '. date('Y', $end_date);
			}
		} else if ( !$multi_day && isset($start_date) ){
			$html_output .= date('M', $start_date) .' <br><span>'. date('j', $start_date) .'</span> <br>'. date('Y', $start_date);
		}
	} else {
		if ( $multi_day && isset($start_date) && isset($end_date) ){
			$html_output .= date('M j, Y', $start_date) .' - '. date('M j, Y', $end_date);
		} else if ( !$multi_day && isset($start_date) ){
			$html_output .= date('M j, Y', $start_date);
		}
	}

	$html_output .= ( $tag ) ? '</time>' : '';

	return $html_output;
}


/*** Get event time ***/
function cs__getEventTime( $post_id, $tag=false ){
	$html_output = '';

	$start_time = get_field('start_time', $post_id);
	$end_time = get_field('end_time', $post_id);

	if ( $start_time || $end_time ){
		$html_output .= ( $tag ) ? '<time>' : '';

		$html_output .= $start_time . ( $end_time ? ' - '. $end_time : '');

		$html_output .= ( $tag ) ? '</time>' : '';
	}

	return $html_output;
}


/*** Change admin columns ***/
add_filter('manage_event_posts_columns', 'cs__change_event_admin_columns');
function cs__change_event_admin_columns( $columns ){
	$new_columns = array();

	foreach ( $columns as $key=>$value ){
		$new_columns[$key] = $value;
		
		if ( $key=='title' ){
			$new_columns['event_date'] = __('Event date', CSWP);
		}
	}

	return $new_columns;
}

add_filter('manage_edit-event_sortable_columns', 'cs__sort_event_admin_columns');
function cs__sort_event_admin_columns( $columns ){
    $columns['event_date'] = 'event_date';
    return $columns;
}

add_action('manage_event_posts_custom_column', 'cs__add_event_admin_columns_value', 10, 2);
function cs__add_event_admin_columns_value($column, $post_id){
	if ( $column=='event_date' ){
		echo cs__getEventDate($post_id);
	}
}

add_action('pre_get_posts', 'cs__sort_event_query');
function cs__sort_event_query( $query ){
    $orderby = $query->get('orderby');

    if ( 'event_date'==$orderby ){
        $meta_query = array(
            'relation' => 'OR',
            array(
                'key' => 'start_date',
                'compare' => 'NOT EXISTS', // see note above
            ),
            array(
                'key' => 'start_date',
            ),
        );

        $query->set('meta_query', $meta_query);
        $query->set('orderby', 'meta_value');
    }
}


/*** Calendar ***/
class Calendar {
	private $active_year, $active_month, $active_day;
	private $calendar_type;
	private $events = [];

	public function __construct( $date=null, $type='' ){
		$this->active_year = ( $date!=null ) ? date('Y', strtotime($date)) : date('Y');
		$this->active_month = ( $date!=null ) ? date('m', strtotime($date)) : date('m');
		$this->active_day = ( $date!=null ) ? date('d', strtotime($date)) : date('d');
		$this->calendar_type = ( $type!='null' ) ? $type : '';
	}

	public function add_event( $txt, $date, $days=1 ){
		$this->events[] = [$txt, $date, $days];
	}

	public function __toString(){
		$current_page = strtok($_SERVER['REQUEST_URI'], '?');
		$button_href = ( isset($_GET['view']) ) ? $current_page .'?view='. $_GET['view'] .'&date=' : $current_page .'?date=';

		$num_days = date('t', strtotime($this->active_day .'-'. $this->active_month .'-'. $this->active_year));
		$num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_day .'-'. $this->active_month .'-'. $this->active_year)));
		$days = [0 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat'];
		$first_day_of_week = array_search(date('D', strtotime($this->active_year .'-'. $this->active_month .'-1')), $days);

		$html = '<div class="calendar'. ( $this->calendar_type!='' ? ' is-type-'. $this->calendar_type : '' ) .'">';
		$html .= '<div class="calendar__header">';
		$html .= '<a class="calendar__arrow calendar__arrow--prev" href="'. $button_href . date('Y-m', strtotime($this->active_year .'-'. $this->active_month .' -1 month')) .'">←</a>';
		$html .= '<div class="calendar__month-year">';
		$html .= date('F Y', strtotime($this->active_year .'-'. $this->active_month .'-'. $this->active_day));
		$html .= '</div>';
		$html .= '<a class="calendar__arrow calendar__arrow--next" href="'. $button_href . date('Y-m', strtotime($this->active_year .'-'. $this->active_month .' +1 month')) .'">→</a>';
		$html .= '</div>';

		$html .= '<div class="calendar__body">';
		foreach ( $days as $day ){
			$html .= '<div class="calendar__weekday-name">'. $day .'</div>';
		}

		for ( $i=$first_day_of_week; $i>0; $i-- ){
			$day_modifier = ' is-other-month';
			if ( $i<$this->active_day ) {
				$day_modifier .= ' is-past';
			}
			$html .= '<div class="calendar__day'. $day_modifier .'"><p class="calendar__day-number">'. ( $num_days_last_month-$i+1 ) .'</p></div>';
		}

		for ( $i=1; $i<=$num_days; $i++ ){
			$day_modifier = '';
			if ( $i==$this->active_day ){
				$day_modifier .= ' is-current';
			} else if ( $i<$this->active_day ) {
				$day_modifier .= ' is-past';
			}
			foreach ( $this->events as $event ){
				for ( $d=0; $d<=($event[2]-1); $d++ ){
					if ( date('y-m-d', strtotime($this->active_year .'-'. $this->active_month .'-'. $i .' -'. $d .' day')) == date('y-m-d', strtotime($event[1])) ){
						$day_modifier .= ' has-events';
					}
				}
			}

			$html .= '<div class="calendar__day'. $day_modifier .'">';
			$html .= '<p class="calendar__day-number">'. $i .'</p>';

			$html .= '<div class="calendar__events">';
			foreach ( $this->events as $event ){
				for ( $d=0; $d<=($event[2]-1); $d++ ){
					if ( date('y-m-d', strtotime($this->active_year .'-'. $this->active_month .'-'. $i .' -'. $d .' day')) == date('y-m-d', strtotime($event[1])) ){
						$html .= '<div class="calendar__event">';
						$html .= $event[0];
						$html .= '</div>';
					}
				}
			}
			$html .= '</div>';
			$html .= '</div>';
		}

		for ( $i=1; $i<=(42-$num_days-max($first_day_of_week, 0)); $i++ ){
			$day_modifier = ' is-other-month';
			$html .= '<div class="calendar__day'. $day_modifier .'"><p class="calendar__day-number">'. $i .'</p></div>';
		}

		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}
}


/*** Get events calendar ***/
function cs__getEventsCalendar( $category=null, $type='' ){
	$current_date = date('Y-m');
	if ( isset($_GET) ){
		$current_date = ( isset($_GET['date']) ) ? $_GET['date'] : date('Y-m');
	}

	$calendar = new Calendar($current_date, $type);

	if ( $current_date==date('Y-m') ){
		$interval_start = date('Y-m-01');
		$interval_end = date('Y-m-t');
	} else if ( $current_date!='' ) {
		$interval_start = date($current_date .'-01');
		$interval_end = date($current_date .'-t');
	}
	$args = array(
		'post_type'	=> 'event',
		'posts_per_page' => -1,
		'meta_key' => 'start_date',
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'meta_query' => array(
			'relation' => 'OR',
			array(
				'key' => 'start_date',
				'compare' => 'BETWEEN',
				'value' => array($interval_start, $interval_end),
				'type' => 'DATETIME',
			),
			array(
				'key' => 'end_date',
				'compare' => 'BETWEEN',
				'value' => array($interval_start, $interval_end),
				'type' => 'DATETIME',
			)
		),
	);
	if ( $category ){
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'event_category',
				'field' => 'id',
				'terms' => array($category)
			)
		);
	}
	$event_query = new WP_Query($args);


	if ( $event_query->have_posts() ):
		while ( $event_query->have_posts() ): $event_query->the_post();
			$post_id = get_the_ID();
			$multi_day = get_field('multi_day', $post_id);
			$start_date = get_field('start_date', $post_id);
			$start_time = get_field('start_time', $post_id);
			$end_time = get_field('end_time', $post_id);
			if ( $multi_day ){
				$end_date = get_field('end_date', $post_id);
			}

			if ( $multi_day && isset($start_date) && isset($end_date) ){
				$start_date_obj = new DateTime($start_date);
				$end_date_obj = new DateTime($end_date);
				$interval = $start_date_obj->diff($end_date_obj);
				$calendar->add_event('<a class="builtin" href="'. get_the_permalink() .'" title="Learn more: '. get_the_title() .'">'. get_the_title() .'</a>', $start_date, $interval->days+1);
			} else if ( !$multi_day && isset($start_date) ){
				$event_time = '<time>';
				$event_time .= ( $start_time!='' ) ? $start_time : '';
				$event_time .= ( $end_time!='' ) ? ' - '. $end_time : '';
				$event_time .= ( $event_time!='' && $event_time!='<time>' ) ? '</time>' : '';
				$calendar->add_event('<a class="builtin" href="'. get_the_permalink() .'" title="Learn more: '. get_the_title() .'">'. $event_time .'<br>'. get_the_title() .'</a>', $start_date, 1);
			}
		endwhile;
	endif; wp_reset_query();

	echo $calendar;
}