<?php
/*
Plugin Name: Columnify Wordpress
Plugin URI: https://github.com/markotom/columnify-wordpress
Description: Create columns with widgets
Author: Marco Godínez <markotom@gmail.com>
Author URI: https://github.com/markotom
Version: 0.0.0
*/

function get_dividers_by_sidebar( $sidebar ) {
  $sidebars = wp_get_sidebars_widgets();
  if ( isset( $sidebars[ $sidebar ] ) ) {
    return preg_grep( '/column_divider/', $sidebars[ $sidebar ] );
  }
};

function get_column_class( $sidebar, $grid = 12 ) {
  $dividers = count( get_dividers_by_sidebar( $sidebar ) );
  if ( $dividers ) {
    $columns = $dividers + 1;
    return 'col-sm-' . floor( ( $grid / $columns ) );
  }
}

function widget_params( $params ) {
  if ( $params[0][ 'widget_name' ] === 'Column Divider' ) {
    $class = get_column_class( $params[ 0 ][ 'id' ] );
    echo '</div><div class="' . $class . '">';
  }

  return $params;
}

add_filter( 'dynamic_sidebar_params', 'widget_params' );

add_action( 'dynamic_sidebar_before', function ($sidebar) {
  $class = get_column_class( $sidebar );
  if ( $class ) {
    echo '<div class="' . $class . '">';
  }
});

add_action( 'dynamic_sidebar_after', function ($sidebar) {
  $class = get_column_class( $sidebar );
  if ( $class ) {
    echo '</div>';
  }
});

function register_widgets() {
  // Register Column_Divider_Widget
  register_widget( 'Column_Divider_Widget' );
}

add_action( 'widgets_init', 'register_widgets' );
add_action( 'widgets_admin_page', array( 'Column_Divider_Widget', 'headers' ), -1000 );

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

  static function headers() {
    if ( is_admin () ) {
      $plugin_url = plugin_dir_url( __FILE__ );

      wp_register_style( 'divider_widget', $plugin_url . '/css/divider_widget.css' );
      wp_enqueue_style( 'divider_widget' );
    }
  }

}



?>
