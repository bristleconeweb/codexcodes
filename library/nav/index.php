<?php

/**
 * Must have namespace match CodexCodes\[directory name]
 * Must have function [directory name]_shortcode_handler
 */

namespace CodexCodes\nav;

function nav_shortcode_handler( $atts, $content = null ) {
    //defaults according to https://codex.wordpress.org/Function_Reference/wp_nav_menu
    $atts = shortcode_atts( array(
	    'theme_location'  => '',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => false,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'           => 0,
		'walker'          => '',
    ), $atts );
    $atts['echo'] = false;
    if (class_exists($atts['walker'])) {
    	$atts['walker'] = new $atts['walker']();
    }
    return wp_nav_menu( $atts );
}
