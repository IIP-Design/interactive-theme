<?php
namespace Inter;

class Customize_Analytics {
  
  // Initialize customize theme class
  public static function init() {
    new self();
  }

  // Initalize admin page that customizes the Interactive theme
  public function __construct() {
    add_action( 'wp_head', array( $this, 'insert_gtm_head' ) );
    add_action( 'tha_body_top', array( $this, 'insert_gtm_body') );
  }

  // Inserts Google Tag Manager snippets into head and body
  function insert_gtm_head() {
    $gtm_id = get_option( 'inter-gtm-id' );
    
    $gtm_header = "<!-- Google Tag Manager -->";
    $gtm_header .= "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':";
    $gtm_header .= "new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],";
    $gtm_header .= "j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=";
    $gtm_header .= "'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);";
    $gtm_header .= "})(window,document,'script','dataLayer','" . $gtm_id . "');</script>";
    $gtm_header .= "<!-- End Google Tag Manager -->";
    
    if ( isset( $gtm_id ) ) {
      echo $gtm_header;
    }
  }

  function insert_gtm_body() {
    $gtm_id = get_option( 'inter-gtm-id' );

    $gtm_body = "<!-- Google Tag Manager (noscript) -->";
    $gtm_body .= "<noscript><iframe src='https://www.googletagmanager.com/ns.html?id=" . $gtm_id . "'";
    $gtm_body .= "height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>";
    $gtm_body .= "<!-- End Google Tag Manager (noscript) -->";

    if ( isset( $gtm_id ) ) {
      echo $gtm_body;
    }
  }
}