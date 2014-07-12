<?php
/**
 * @package columnify
 * @version 0.0.1
 */
/*
Plugin Name: Columnify
Plugin URI: https://github.com/markotom/columnify-wordpress
Description: Creates columns with widgets quickly and painless.
Author: Marco Godínez <markotom@gmail.com>
Author URI: https://github.com/markotom
Version: 0.0.1
*/

$plugin_directory = dirname( __FILE__ );

require_once $plugin_directory . '/includes/widgets/divider.php';
require_once $plugin_directory . '/includes/class-columnify-renderer.php';

function column_renderer() {
  global $column_renderer;

  $column_renderer = new Columnify_Renderer();
}

add_filter( 'widgets_init', 'column_renderer' );

function register_widgets() {
  // Register Column_Divider_Widget
  register_widget( 'Columnify_Divider_Widget' );
}

add_action( 'widgets_init', 'register_widgets' );
add_action( 'widgets_admin_page', array( 'Columnify_Divider_Widget', 'headers' ), -1000 );

?>
