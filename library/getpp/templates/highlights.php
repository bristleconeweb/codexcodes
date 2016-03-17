<?php

require_once('utils/utils.php');

/**
 * This function shows thumbnails with title per http://getbootstrap.com/components/#media
 * @param  [type] $posts the posts returned by WordPress
 * @param  [type] $args the original arguments specified in the shortcode
 * @return [type] returns the html output
 */
function getpp_template_highlights($posts, $args){
	$output = '';
	$format = '<div class="media">%1$s<div class="media-body"><a href="%2$s"><b class="media-heading">%3$s</b></a></div></div>';
	global $post;
	$urlid = get_the_ID();
	foreach( $posts as $post ) : setup_postdata($post); 
		if(getpp_depth_permitted($args['depth'],getpp_depth($urlid,$post->ID))){
			$vars['img'] = get_the_post_thumbnail($post->ID, 'thumbnail', array('class'=>'media-object pull-left span1'));
			$vars['href'] = get_permalink($post->ID);
			$vars['title'] = $post->post_title;
			$output .= vsprintf($format,$vars);
		}
	endforeach; wp_reset_postdata();
	return $output;
}
add_filter('getpp_template_highlights','getpp_template_highlights',10,2); 
