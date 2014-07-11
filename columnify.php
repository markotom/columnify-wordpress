<?php
/*
Plugin Name: Columnify Wordpress
Plugin URI: https://github.com/markotom/columnify-wordpress
Description: Create columns with widgets
Author: Marco Godínez <markotom@gmail.com>
Author URI: https://github.com/markotom
Version: 0.0.0
*/

function register_widgets() {
  // Register Column_Divider_Widget
  register_widget( 'Column_Divider_Widget' );
}

add_action( 'widgets_init', 'register_widgets' );

/**
 * Column Divider
 * Separate your widgets by columns
 */
class Column_Divider_Widget extends WP_Widget {

  function __construct() {
    parent::__construct(
      'column_divider',
      __( 'Column Divider', 'columnify_wordpress' ),
      array( 'description' => __( 'Column Divider Widget', 'columnify_wordpress' ) )
    );
  }

  public function widget( $args, $instance ) {
    // no widget
  }

  public function form( $instance ) {
    // no form
  }

  public function update( $new_instance, $old_instance ) {}

}

?>
