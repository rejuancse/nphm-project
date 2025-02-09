<?php
/**
 * CPT Exhibitions
 */


/*** Get exhibition date ***/
function cs__getExhibitionDate( $blocks, $needle ){
	foreach ( $blocks as $block ){
		if ( !empty($block['innerBlocks']) ){
			cs__getExhibitionDate($block['innerBlocks'], $needle);
		} elseif ( $block['blockName']===$needle ){
			echo $block['attrs']['data']['dates'];
			break;
		}
	}
}