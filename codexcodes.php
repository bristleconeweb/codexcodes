<?php
/*
Plugin Name:        CodexCodes
Plugin URI:         https://github.com/bristweb/codexcodes
Description:        Deeply integrated shortcodes for WordPress
Version:            .1
Author:             Bristlecone Web
Author URI:         https://bristleconeweb.com/

License:            GNU GPLv2
License URI:        https://github.com/bristweb/codexcodes/blob/master/LICENSE
*/

namespace CodexCodes;

function load_shortcodes() {
  foreach (glob(__DIR__ . '/library/*') as $dir) {
     require_once $dir . '/index.php';
     load_templates($dir);
     add_shortcode( basename($dir),  'CodexCodes\\' . basename($dir) . '\\' . basename($dir) . '_shortcode_handler' );
  }
}

function load_templates($dir) {
	foreach (glob($dir . '/templates/*.php') as $file) {
     require_once $file;
  }
}
add_action('after_setup_theme', __NAMESPACE__ . '\\load_shortcodes', 100);

/**
 * Add clear link to documentation from plugins list
 */
function plugin_row_meta($links, $file) {
    $plugin = plugin_basename(__FILE__);
    if ($file == $plugin) {
        return array_merge(
            $links,
            array( sprintf( '<a target="_blank" href="https://github.com/bristweb/codexcodes">%s</a>',  __('Documentation') ) )
        );
    }
    return $links;
}
add_filter( 'plugin_row_meta',  __NAMESPACE__ . '\\plugin_row_meta', 10, 2 );

