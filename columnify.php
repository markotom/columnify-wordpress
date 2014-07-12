<?php
/*
Plugin Name: Columnify Wordpress
Plugin URI: https://github.com/markotom/columnify-wordpress
Description: Create columns with widgets
Author: Marco Godínez <markotom@gmail.com>
Author URI: https://github.com/markotom
Version: 0.0.0
*/

function column_renderer() {
  global $column_renderer;

  $column_renderer = new Column_Renderer();
}

add_filter( 'widgets_init', 'column_renderer' );

/**
 * Column Renderer
 * Filter sidebars widgets and render columns
 */
class Column_Renderer {

  var $grid = 12;
  var $sidebars;
  var $sidebars_widgets;

  function __construct() {
    // Get sidebars widgets
    add_filter( 'sidebars_widgets', array( &$this, 'get_sidebars_widgets' ) );

    // Create first column
    add_action( 'dynamic_sidebar_before', array( &$this, 'create_first_column' ) );

    // Create break column by column classes
    add_filter( 'dynamic_sidebar_params', array( &$this, 'create_break_column' ) );

    // Create last column (close column div)
    add_action( 'dynamic_sidebar_after', array( &$this, 'create_last_column' ) );
  }

  public function get_sidebars_widgets( $sidebars_widgets ) {
    $this->sidebars_widgets = $sidebars_widgets;
    unset( $this->sidebars_widgets[ 'wp_inactive_widgets' ] );

    foreach ( $this->sidebars_widgets as $sidebar => $widgets ) {
      $current_sidebar = &$this->sidebars[ $sidebar ];
      $current_sidebar[ 'dividers' ] = preg_grep( '/column_divider/', $widgets );
      $current_sidebar[ 'column_classes' ] = $this->set_column_classes( $current_sidebar[ 'dividers' ] );
    }

    return $sidebars_widgets;
  }

  private function set_column_classes( $column_dividers ) {
    $count_column_dividers = count( $column_dividers );

    if ( $count_column_dividers > 0 ) {
      $columns = $count_column_dividers + 1;
      $columns = $columns > $this->grid ? $this->grid : $columns;

      return 'col-sm-' . floor( ( $this->grid / $columns ) );
    }
  }

  private function get_column_classes( $sidebar ) {
    return $this->sidebars[ $sidebar ][ 'column_classes' ];
  }

  public function create_break_column( $params ) {
    $widget_name = $params[ 0 ][ 'widget_name' ];
    $widget_sidebar = $params[ 0 ][ 'id' ];

    if ( ! is_admin () && $widget_name === 'Column Divider' ) {
      $classes = $this->get_column_classes( $widget_sidebar );
      echo '</div><div class="' . $classes . '">';
    }

    return $params;
  }

  public function create_first_column( $sidebar ) {
    $classes = $this->get_column_classes( $sidebar );

    if ( $classes ) {
      echo '<div class="' . $classes . '">';
    }
  }

  public function create_last_column( $sidebar ) {
    $classes = $this->sidebars[ $sidebar ][ 'column_classes' ];

    if ( $classes ) {
      echo '</div>';
    }
  }

}

function register_widgets() {
  // Register Column_Divider_Widget
  register_widget( 'Column_Divider_Widget' );
}

add_action( 'widgets_init', 'register_widgets' );
add_action( 'widgets_admin_page', array( 'Column_Divider_Widget', 'headers' ), -1000 );

/**
 * Column Divider Widget
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
