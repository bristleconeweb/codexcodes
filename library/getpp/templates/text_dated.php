<?php

require_once('utils/utils.php');

/**
 * This function shows the headline, date and description without thumbnails
 * @param  [type] $posts the posts returned by WordPress
 * @param  [type] $args the original arguments specified in the shortcode
 * @return [type] returns the html output
 */
function getpp_template_text_dated($posts, $args){
	$output = '';
	$format = '<p><a href="%1$s"><h4 class="media-heading">%2$s</h4></a><small class="muted">%4$s<br></small>%3$s</p>';
	global $post;
	$urlid = get_the_ID();
	foreach( $posts as $post ) : setup_postdata($post); 
		if(getpp_depth_permitted($args['depth'],getpp_depth($urlid,$post->ID))){
			$vars['href'] = get_permalink($post->ID);
			$vars['title'] = $post->post_title;
			$vars['excerpt'] = get_the_excerpt();
			$vars['date'] = get_the_date();
			$output .= vsprintf($format,$vars);
		}
	endforeach; wp_reset_postdata();
	return $output;
}
add_filter('getpp_template_text_dated','getpp_template_text_dated',10,2); 
