<?php

/**
 * Autoload classes - any class that is in the includes dir with a '[NAME]_class.php file format will be autoloaded'
 */
require_once get_stylesheet_directory() . '/includes/autoloader.php';

Inter_Autoloader::register( get_stylesheet_directory() . '/includes/' );

use Inter\Twig as Twig;
use Inter\Content_Block as Content_Block;
use Inter\Content_Block_Shortcode as Content_Block_Shortcode;
use Inter\Custom_Button_Shortcode as Custom_Button_Shortcode;
use Inter\Custom_Iframe_Shortcode as Custom_Iframe_Shortcode;
use Inter\Content_Type_Tax as Content_Type_Tax;

class InteractiveSite {

	/**
	 * Initializes theme
	 * Addtional initialization is done within the Corona theme, i.e. theme support, textdomain, etc
	 * @see corona/lib/init.php
	 * @param  string $dir absolute path to twig template directory
	 */
	function __construct() {
		add_filter( 'corona_add_constants', array( $this, 'add_constants' ) );

		add_filter( 'twig_init', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'register_shortcodes' ) );
		add_action( 'init', array(  $this, 'excerpt_more_override') );
		add_action( 'admin_menu', array( $this, 'admin_remove_menu_pages' ), 999 );
		add_action( 'admin_init', array( $this, 'admin_remove_corona_shortcode_button') );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 5 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'pre_get_posts', array( $this, 'search_filter') );
		add_filter( 'frm_notification_attachment', array( $this, 'inter_add_attachment'), 10, 3 );
		add_filter( 'frm_encode_subject', array( $this, 'frm_encode_subject') );
    // add_action( 'wp_head', array( $this, 'insert_gtm_head') );
		// add_action( 'tha_body_top', array( $this, 'insert_gtm_body') );
		// add_action( 'wp_head', array( $this, 'insert_dap') );
		// add_action( 'wp_head', array( $this, 'insert_hotjar') );
		add_filter( 'attachment_fields_to_edit', array( $this, 'inter_attachment_fields' ), 10, 2 );
		add_action( 'edit_attachment', array( $this, 'inter_update_attachment_meta' ) );
		add_action( 'wp_ajax_save-attachment-compat', array( $this, 'inter_media_custom_fields' ) );
		
		$this->twig_init();

		/*
		* Register JSON Data to WP API
		*/
		require_once 'includes/wp_api_register_json.php';

		/*
		* Include Page Templates' CMB2 Fields
		*/
		foreach( glob(get_stylesheet_directory() . '/includes/wp_custom_tmpl_fields/*.php') as $custom_field_file ) {
			require_once $custom_field_file;
		}

		/*
		* Add Custom Shortcode Dropdown List to TinyMCE - must be after Inter_Autoloader
		*/
    require_once 'includes/tinymce_dropdown/tinymce_dropdown.php';

		/*
		* Add excerpt to pages
		*/
		add_post_type_support( 'page', 'excerpt' );

		/*
		* IIP Interactive Plugin Edits
		*/
		require_once get_stylesheet_directory() . '/includes/edit-iip-interactive-plugin/edit-iip-interactive.php';

	}

	function twig_init() {
		Twig::$locations = array( 'twig-templates' );
		Twig::init();
	}

	function add_constants( $constants ) {
		$interactive_constants = array(
			'CHILD_THEME_VERSION' => corona_get_theme_version( get_stylesheet_directory() . '/version.json' )
		);
		$constants = array_merge( $interactive_constants, $constants );
		return $constants;
	}

	/**
	 * Registers custom post types
	 *
	 * @return void
	 */
	function register_post_types() {
		Content_Block::register();
	}

	function register_taxonomies() {
		// this is where you can register custom taxonomies
		Content_Type_Tax::register();
	}

	function register_shortcodes() {
		Content_Block_Shortcode::register();
    Custom_Button_Shortcode::register();
    Custom_Iframe_Shortcode::register();
	}

	function enqueue_scripts() {
		global $post;
		$module_url = self::cdp_get_option('cdp_module_url');
		$public_api = self::cdp_get_option('cdp_public_url');
		$search_indexes = self::cdp_get_option('cdp_indexes');

		$article_feed_js = $module_url . "cdp-module-article-feed/cdp-module-article-feed.min.js";
		$article_feed_css = $module_url . "cdp-module-article-feed/cdp-module-article-feed.min.css";

		if ( !has_shortcode( $post->post_content, 'course' ) ) {
			wp_enqueue_script( 'article-feed-js', $article_feed_js, null, '1.0.0', true );
			wp_enqueue_style( 'article-feed-css', $article_feed_css, null, '1.0.0' );
		}

		wp_register_script( 'inter-js', get_stylesheet_directory_uri() . '/dist/js/bundle.min.js', array('jquery'), CHILD_THEME_VERSION, true );
		wp_localize_script( 'inter-js', 'cdp', array(
			'publicAPI'  => $public_api,
			'searchIndexes'  => $search_indexes
		));
		wp_enqueue_script( 'inter-js' );
	}

	function admin_enqueue_scripts() {
		wp_enqueue_style( 'inter-admin-css', get_stylesheet_directory_uri() . '/style-admin.css' );
	}

	function admin_remove_menu_pages() {
		if ( !current_user_can( 'manage_sites' ) ) {
			remove_menu_page('vc-welcome');
		}
	}

	function admin_remove_corona_shortcode_button(){
		$instance = TinyMce_Btn_Shortcode::instance();
		remove_filter("mce_external_plugins", array ( $instance, 'corona_add_js_to_load' ) );
	}

	function add_to_twig( $twig ) {
		/* add additional contextual functions to twig */
		return $twig;
	}

	/*
	* Excerpt Read More Edit
	*/
	function excerpt_more_override() {
		remove_filter('excerpt_more', 'corona_excerpt_read_more');
		add_filter('excerpt_more', function($more) {
			global $post;
			return '&nbsp; <a href="' . get_permalink($post->ID) . '"> Read More...</a>';
		});
	}

	/*
	* Edit Search Query - Query only Posts
	*/
	function search_filter($query) {
		if( $query->is_main_query() && $query->is_search() ) {
			$query->set('post_type', array('post', 'page'));
			$query->set('posts_per_page', '-1');
		}
	}

	// Helpers
	public static function cdp_get_option( $key = '', $default = false ) {
    if ( function_exists( 'cmb2_get_option' ) ) {
      // Use cmb2_get_option as it passes through some key filters.
      return cmb2_get_option( 'cdp_options', $key, $default );
    }

    // Fallback to get_option if CMB2 is not loaded yet.
    $opts = get_option( 'cdp_options', $default );
    $val = $default;

    if ( 'all' == $key ) {
      $val = $opts;
    } elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
      $val = $opts[ $key ];
    }

    return $val;
  }

	/* ANALYTICS */
	// Inserts Google Tag Manager snippets into head and body
	function insert_gtm_head() {
		?>
			<!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-TTR686');</script>
			<!-- End Google Tag Manager -->
		<?php
	}

	function insert_gtm_body() {
		?>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TTR686"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		<?php
	}

	// Inserts Digital Analytics Program (DAP) code
	function insert_dap(){
		?>
		  <!-- Digital Analytics Program -->
			<script async type="text/javascript" src="https://dap.digitalgov.gov/Universal-Federated-Analytics-Min.js?agency=DOS&siteplatform=inter" id="_fed_an_ua_tag"></script>
			<!-- End Digital Analytics Program -->
		<?php
	}

	// Insert Hotjar Tagging
	function insert_hotjar() {
		?>
		<!-- Hotjar Tracking  -->
		<script>
		    (function(h,o,t,j,a,r){
		        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
		        h._hjSettings={hjid:690455,hjsv:6};
		        a=o.getElementsByTagName('head')[0];
		        r=o.createElement('script');r.async=1;
		        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
		        a.appendChild(r);
		    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
		</script>
		<!-- End Hotjar Tracking  -->
		<?php
	}
	/* END ANALYTICS */

	/**
	 * Add custom attribution field to media attachments
	 */
	function inter_attachment_fields( $fields, $post ) {
		$attribution_value = get_post_meta($post->ID, '_attribution', true);
		$fields['attribution'] = array(
			'label' => __( 'Attribution' ),
			'input' => 'text',
			'value' => $attribution_value,
			'show_in_edit' => true
		);
		return $fields;         
	}

	/**
	 * Update custom attribution field on save
	 */
	function inter_update_attachment_meta( $attachment ) {
		$attribution = isset( $_POST['attachments'][$attachment]['attribution'] ) ? $_POST['attachments'][$attachment]['attribution'] : false;
		update_post_meta($attachment, '_attribution', $attribution);
		return;
	}

	/**
   * Update custom attribution field via ajax
	 */
	function inter_media_custom_fields() {
		$post_id = $_POST['id'];
		$meta = $_POST['attachments'][$post_id]['attribution'];
		update_post_meta($post_id, '_attribution', $meta);
		clean_post_cache($post_id);
	}
}

new InteractiveSite();
