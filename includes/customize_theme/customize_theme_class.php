<?php
namespace Inter;

class Customize_Theme {

  // Initialize customize theme class
  public static function init() {
    new self();
  }

  // Initalize admin page that customizes the Interactive theme
  public function __construct() {
    add_action( 'admin_menu', array( $this, 'add_customize_theme_submenu' ) );
    add_action( 'admin_init', array( $this, 'add_submenu_sections') );
    add_action( 'admin_init', array( $this, 'formidable_settings' ) );
    add_action( 'admin_init', array( $this, 'analytics_settings' ) );
  }

  // Add Interactive theme submenu page 
  function add_customize_theme_submenu() { 
    add_submenu_page(
      'themes.php',
      __( 'Interactive Theme', 'inter' ),
      __( 'Interactive Theme', 'inter' ),
      'edit_themes',
      'edit-inter-theme',
      array( $this, 'populate_submenu_form' )
    );
  }

  // Create form for customization input values
  function populate_submenu_form() {
    ?>
    <div class="wrap">
      <h1 class='wp-heading-inline'><?php _e( 'Edit Interactive Theme Settings', 'inter' ) ?></h1>
      <hr class='wp-header-end'>
      <form action="options.php" method="post">
        <?php
          do_settings_sections( 'edit-inter-theme' );
          settings_fields( 'edit-inter-theme' );
          submit_button();
        ?>
      </form>
    </div>
    <?php
  }

  // Create settings sections
  function add_submenu_sections(){
    add_settings_section(
      'formidable-forms',                                 // Section ID
      __( 'Formidable Forms', 'inter' ),                  // Section title
      array( $this, 'formidable_section_description' ),   // Section callback function
      'edit-inter-theme'                                  // Settings page slug
    );
    add_settings_section(
      'inter-analytics',                                 // Section ID
      __( 'Site Analytics', 'inter' ),                  // Section title
      array( $this, 'analytics_section_description' ),   // Section callback function
      'edit-inter-theme'                                  // Settings page slug
    );
  }

  // Set description for the formidable form settings section
  function formidable_section_description() {
    _e( 'Use the field(s) below to enter Formidable shortcodes.', 'inter' );
  }

  function analytics_section_description() {
    _e( 'Use the field(s) below to enter in Analytics information for site.', 'inter' );
  }

  function formidable_settings(){
    // Create join us form settings field
    add_settings_field(
      'inter-joinus-form-id',                        // Field ID
      __( 'Get in Touch:', 'inter' ),                // Field title 
      array( $this, 'joinus_input_markup' ),         // Field callback function
      'edit-inter-theme',                            // Settings page slug
      'formidable-forms',                            // Section ID
      array( 'label_for' => 'inter-joinus-form-id' ) // Display field title as label
    );

    // Register join us form settings
    register_setting(
      'edit-inter-theme',         // Options group
      'inter-joinus-form-id',     // Option name/database
      'sanitize_text_field'       // Sanitize input value
    );
  }

  // HTML markup for the formidable join us form id
  function joinus_input_markup() {
    $formidable_id = get_option( 'inter-joinus-form-id' );
    $html = '<fieldset>';
      $html .= '<input ';
        $html .= 'id="inter-joinus-form-id" ';
        $html .= 'name="inter-joinus-form-id" ';
        $html .= 'placeholder="[formidable id=1]" ';
        $html .= 'type="text" ';
        $html .= 'value="' . $formidable_id;
      $html .= '">';
    $html .= '</fieldset>';
    echo $html;
  }

  function analytics_settings(){
    //Create Analytics Sectiohn Settings Fields
    add_settings_field(
      'inter-ga-id',                             // Field ID
      __( 'Google Analytics (UA):', 'inter' ),   // Field title 
      array( $this, 'ga_input_markup' ),         // Field callback function
      'edit-inter-theme',                        // Settings page slug
      'inter-analytics',                         // Section ID
      array( 'label_for' => 'inter-ga-id' )      // Display field title as label
    );
    add_settings_field(
      'inter-gtm-id',                             // Field ID
      __( 'Google Tag Manager (GTM):', 'inter' ), // Field title 
      array( $this, 'gtm_input_markup' ),         // Field callback function
      'edit-inter-theme',                         // Settings page slug
      'inter-analytics',                          // Section ID
      array( 'label_for' => 'inter-gtm-id' )      // Display field title as label
    );

    //Register Analytics Section Settings
    register_setting(
      'edit-inter-theme',                             // Options group
      'inter-ga-id',                                  // Option name/database
      array(
        'sanitize_callback' => 'sanitize_text_field'  // Sanitize input value
      )
    );
    register_setting(
      'edit-inter-theme',
      'inter-gtm-id',
      array(
        'sanitize_callback' => 'sanitize_text_field'
      )
    );
  }

  // HTML markup for analytics form inputs
  function ga_input_markup() {
    $ga_id = get_option( 'inter-ga-id' );
    $html = '<fieldset>';
      $html .= '<input ';
        $html .= 'id="inter-ga-id" ';
        $html .= 'name="inter-ga-id" ';
        $html .= 'placeholder="Google Analytics (UA)" ';
        $html .= 'style="width: 250px; ';
        $html .= 'type="text" ';
        $html .= 'value="' . $ga_id;
      $html .= '">';
    $html .= '</fieldset>';
    echo $html;
  }
  function gtm_input_markup() {
    $gtm_id = get_option( 'inter-gtm-id' );
    $html = '<fieldset>';
      $html .= '<input ';
        $html .= 'id="inter-gtm-id" ';
        $html .= 'name="inter-gtm-id" ';
        $html .= 'placeholder="Google Tag Manager (GTM)" ';
        $html .= 'style="width: 250px; ';
        $html .= 'type="text" ';
        $html .= 'value="' . $gtm_id;
      $html .= '">';
    $html .= '</fieldset>';
    echo $html;
  }
}