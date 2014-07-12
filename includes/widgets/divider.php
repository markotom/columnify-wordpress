<?php

/**
 * Adds column widget to widgets admin
 *
 * @since 0.0.1
 */
class Columnify_Divider_Widget extends WP_Widget {

  function __construct() {
    parent::__construct(
      'column_divider',
      __( 'Column Divider', 'columnify_wordpress' ),
      array( 'description' => __( 'Column Divider Widget', 'columnify_wordpress' ) )
    );
  }

  public function widget( $args, $instance ) {}

  public function form( $instance ) {}

  static function headers() {
    if ( is_admin () ) {
      $plugin_url = plugin_dir_url( __FILE__ ) . '../../';

      wp_register_style( 'columnify_divider_widget', $plugin_url . '/css/divider_widget.css' );
      wp_enqueue_style( 'columnify_divider_widget' );
    }
  }

}

?>
