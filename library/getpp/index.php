<?php

/**
 * Must have namespace match directory name
 * Must have function shortcode_handler
 */

namespace CodexCodes\getpp;

function getpp_shortcode_handler( $args, $content = null ) {
	$template = getpp_template_setter($args);
	unset($args['template']);
	$args = getpp_args_setter($args);
	$posts = getpp_posts_setter($args);
	return getpp_output($template,$posts,$args);
}

function getpp_template_setter($args){
	$template = 'getpp_template_' . $args['template'];
	if(!array_key_exists($template, $GLOBALS['wp_filter'])) {
		$template = 'getpp_template_default';
	}
	return $template;
}

function getpp_args_setter($args){
	add_filter('getpp_arg_dynamic_replacements', __NAMESPACE__ . '\\getpp_arg_dynamic_replacements', 10); 
	return apply_filters('getpp_arg_dynamic_replacements', $args);
}

function getpp_posts_setter($args){
	$func = $args['func'];
	if (function_exists($func)) {
		return $func($args);
	}
	return "Shortcode needs a valid 'func' parameter.";
}

function getpp_output($template,$posts,$args){
	if (empty($posts))
		return;
	return apply_filters($template,$posts,$args);
}

function getpp_arg_dynamic_replacements($args){
	add_filter('getpp_replace_hierarchicals', __NAMESPACE__ . '\\getpp_replace_hierarchicals', 10); 
	add_filter('getpp_replace_categoricals', __NAMESPACE__ . '\\getpp_replace_categoricals', 10); 
	add_filter('getpp_auto_set_post_type', __NAMESPACE__ . '\\getpp_auto_set_post_type', 10); 
	$replacements = array(
		'parent'	=> 'getpp_replace_hierarchicals',
		'child_of'	=> 'getpp_replace_hierarchicals', 
		'include'	=> 'getpp_replace_hierarchicals', 
		'exclude'	=> 'getpp_replace_hierarchicals', 
		'post_type'	=> 'getpp_auto_set_post_type'
		);
	foreach ($args as $key => $value){
		if (!empty($replacements[$key])){
			$args[$key] = apply_filters($replacements[$key],$args[$key]);
		}
	}
	$args = array_merge(array('depth'=>null),$args);
	return $args;
}

function getpp_auto_set_post_type($value){
	if(empty($value))
		return get_post_type(get_the_ID());
	return $value;
}

function getpp_replace_hierarchicals($value){
	$value = str_replace('this', get_the_ID(), $value);
	$value = str_replace('parent', wp_get_post_parent_id(get_the_ID()), $value);
	$value = str_replace('top', end(get_post_ancestors(get_the_ID())), $value);
	return $value;	
}
