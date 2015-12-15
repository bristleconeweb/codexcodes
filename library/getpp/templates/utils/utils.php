<?php

/**
 * This function gets the depth of the post/page
 * @param  [type] $elder The top level post.  $younger should be a decendant of $elder
 * @param  [type] $younger   The post we are determining the depth of.
 * @return [type] Returns the generational difference as an integer.  If no $elder is specified, it will be the depth from the root
 */
function getpp_depth($initial, $current){
	$current_depth = count(get_post_ancestors($current));
	$initial_depth = count(get_post_ancestors($initial));
	return $current_depth - $initial_depth;
}

/**
 * This function determines if the object should be shown
 * @param  [type] $allowed_depth level of depth allowed by depth=
 * @param  [type] $item_depth    the calculated depth of the current object
 * @return [type]                boolean true if allowed.  otherwise false.
 */
function getpp_depth_permitted($allowed_depth, $item_depth){
	if(!isset($allowed_depth))
		return true;
	if($item_depth <= $allowed_depth)
		return true;
	return false;
}
