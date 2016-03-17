<?php

require_once('utils/utils.php');

/**
 * This function renders a simple list of posts in a Bootstrap styled format.  You can override this with your own filter.  See remove_filter and add_filter in the codex.
 * @param  [type] $posts the posts returned by WordPress
 * @param  [type] $args  the original arguments specified in the shortcode
 * @return [type] returns the html output
 */
function getpp_template_default($posts, $args){
	$output = '<ul style="padding:0" class="nav nav-list">';
	$format = '<li id="%1$s" class="%5$s"><a style="border: 1px solid #e5e5e5; margin: auto auto -1px;" href="%2$s"><i class="icon-chevron-right pull-right"></i>%4$s%3$s</a></li>';
	global $post;
	$urlid = get_the_ID();
	foreach( $posts as $post ) : setup_postdata($post); 
		if(getpp_depth_permitted($args['depth'],getpp_depth($urlid,$post->ID))){
			$vars['id'] = 'post-'. $post->ID;
			$vars['href'] =	get_permalink($post->ID);
			$vars['title'] = $post->post_title;
			$vars['indent'] = str_repeat('&raquo; ', getpp_depth($urlid,$post->ID)-1);
			$vars['css'] = ($post->ID == get_the_ID())? 'active' : '';
			$output .= vsprintf($format, $vars);
		}
	endforeach; wp_reset_postdata();
	$output .= '</ul>';
	return $output;
}

add_filter('getpp_template_default','getpp_template_default',10,2); 
