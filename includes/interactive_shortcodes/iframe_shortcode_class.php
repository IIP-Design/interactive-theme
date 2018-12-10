<?php

namespace Inter;

class Custom_Iframe_Shortcode {

  public static function register() {
    new self();
  }

  public function __construct() {
    add_shortcode( 'iframe', array( $this, 'render_iframe' ) );
  }
  
  public function render_iframe( $atts ) {
    $atts = shortcode_atts( array(
      'content' => '',
      'src'     => ''
    ), $atts, 'render_iframe' );

    return '<iframe src="' . $atts['src'] . '" ' . $atts['content'] . '></iframe>';
  }
}