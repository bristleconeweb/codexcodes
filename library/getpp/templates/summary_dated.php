<?php

require_once('utils/utils.php');

/**
 * This function shows dated summaries with a thumbnail per http://getbootstrap.com/components/#media
 * @param  [type] $posts the posts returned by WordPress
 * @param  [type] $args the original arguments specified in the shortcode
 * @return [type] returns the html output
 */
function getpp_template_summary_dated($posts, $args){
	$output = '';
	$format = '<div class="media">%1$s<div class="media-body"><a href="%2$s"><h4 class="media-heading">%3$s</h4></a><small class="muted">%5$s<br></small>%4$s</div></div>';
	global $post;
	foreach( $posts as $post ) : setup_postdata($post); 
		if(getpp_depth_permitted($args['depth'],getpp_depth(get_the_ID(),$post->ID))){
			$vars['img'] = get_the_post_thumbnail($post->ID, 'thumbnail', array('class'=>'media-object pull-left'));
			$vars['href'] = get_permalink($post->ID);
			$vars['title'] = $post->post_title;
			$vars['excerpt'] = get_the_excerpt();
			$vars['date'] = get_the_date();
			$output .= vsprintf($format,$vars);
		}
	endforeach; wp_reset_postdata();
	return $output;
}
add_filter('getpp_template_summary_dated','getpp_template_summary_dated',10,2); 
