<?php

require_once('utils/utils.php');

/**
 * This function renders a simple list of posts in a Bootstrap styled format.  You can override this with your own filter.  See remove_filter and add_filter in the codex.
 * @param  [type] $posts the posts returned by WordPress
 * @param  [type] $args  the original arguments specified in the shortcode
 * @return [type] returns the html output
 */
function getpp_template_default($posts, $args){
	$format = '<ul style="padding:0" class="nav nav-list">%s</ul>';
	$string = getpp_template_default_items($posts, $args);
	return sprintf($format,$string);
}

function getpp_template_default_items($posts, $mainargs){
	$output = '';
	$format = '<li id="%1$s" class="%5$s"><a style="border: 1px solid #e5e5e5; margin: auto auto -1px;" href="%2$s"><i class="icon-chevron-right pull-right"></i>%4$s%3$s</a></li>';
	foreach ($posts as $key => $post) {
		if(getpp_depth_permitted($mainargs['depth'],getpp_depth(get_the_ID(),$post->ID))){
			$vars['id'] = 'post-'. $post->ID;
			$vars['href'] =	get_permalink($post->ID);
			$vars['title'] = $post->post_title;
			$vars['indent'] = str_repeat('&raquo; ', $mainargs['depth']);
			$vars['css'] = ($post->ID == get_the_ID())? 'active' : '';
			$output .= vsprintf($format, $vars);
		}
	} 
	return $output;
}

add_filter('getpp_template_default','getpp_template_default',10,2); 
