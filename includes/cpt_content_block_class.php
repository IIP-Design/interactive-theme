<?php

namespace Inter;

use Twig_Inter_Extension;

class Content_Block {

  public function __construct() {
      add_action( 'cmb2_admin_init',                          array($this, 'content_block_fields') );  
      add_action( 'admin_enqueue_scripts',                    array($this, 'cmb2_toggle_metaboxes_JS') );  
      add_filter( 'manage_edit-content_block_columns',        array($this, 'edit_content_block_post_columns') );
      add_filter( 'manage_content_block_posts_custom_column', array($this, 'manage_content_block_post_columns'), 10, 2 );  
  }

  //public function admin_enqueue_scripts() {
  public function cmb2_toggle_metaboxes_JS() {
    wp_enqueue_script( 'cmb2-addon-js', get_stylesheet_directory_uri() . '/assets/admin/cmb2.js',array( 'jquery' ), '1.0.0', true );        
  }
  
  /**
   * Register the Content Block custom post type
   *
   * @return void
   */
  public static function register() {
    $labels = array(
      'name'                => _x( 'Content Blocks', 'post type general name', 'inter' ),
      'singular_name'       => _x( 'Content Block', 'post type singular name', 'inter' ),
      'add_new'             => _x( 'Add New', 'Content Block', 'inter' ),
      'add_new_item'        => __( 'Add New Content Block', 'inter' ),
      'edit_item'           => __( 'Edit Content Block', 'inter' ),
      'new_item'            => __( 'New Content Block', 'inter' ),
      'view_item'           => __( 'View Content Block', 'inter' ),
      'search_items'        => __( 'Search Content Blocks', 'inter' ),
      'not_found'           => __( 'No Content Block found', 'inter' ),
      'not_found_in_trash'  => __( 'No Content Blocks found in Trash', 'inter' ),
      'parent_item_colon'   => ''
    );

    $args = array(
      'labels'              => $labels,
      'public'              => true,
      'publicly_queryable'  => true,
      'show_ui'             => true,
      'show_in_rest'        => true,
      'query_var'           => true,
      'rewrite'             => true,
      'capability_type'     => 'post',
      'hierarchical'        => false,
      'menu_position'       => 5,
      'supports'            => array('title','thumbnail','excerpt'),
      'has_archive'         => true
    );

    register_post_type( 'content_block', $args );
	}

  /**
   * Adds the content block specific metaboxs to admin screen
   *
   * @return void
   */
  public function content_block_fields() {

    $prefix = 'inter_';
  
    /****************************************************************
      Include Content Block Metaboxes
    *****************************************************************/    
    foreach( glob(get_stylesheet_directory() . '/includes/content_block_metaboxes/*.php') as $block_file ) {
      require_once $block_file;
    }
  }  

  /**
   * Fetch Wordpress categories
   * @todo fetch from CDP
   *
   * @return void
   */
  public function fetch_categories() {
    $cat_options =  array();
    $categories = get_categories( array(
     'orderby' => 'name',
     'order'   => 'ASC',
     'hide_empty' => '0'
    ));

    $cat_options['select'] = 'Select';
    foreach( $categories as $category ) {
      if( $category->name != 'Uncategorized' )
      $cat_options[$category->slug] = $category->name;
    }

    return $cat_options;
  }

    /**
   * Fetch Wordpress series
   * @todo fetch from CDP
   *
   * @return void
   */
  public function fetch_tags() {
    $tags_options =  array();
    $tags = get_tags();

    $tags_options['select'] = 'Select';
    foreach( $tags as $tag ) {
      $tags_options[$tag->slug] = $tag->name;
    }

    return $tags_options;
  }


  /**
   * Adds custom column headers to content block admin list
   *
   * @param [type] $columns
   * @return void
   */
  public function edit_content_block_post_columns( $columns ) {
    $columns = array(
        'cb'                => '<input type="checkbox" />',
        'title'             => __( 'Content Block', 'inter' ),
        'author'            => __( 'Author', 'inter' ),
        'date'              => __( 'Date', 'inter' ),
        'display_shortcode' => __( 'Display Shortcode', 'inter' )
    );

    return $columns;
  }

  public function manage_content_block_post_columns($column, $post_id) {
    global $post;

    switch( $column ) {
      case 'display_shortcode':
        echo '<input style="width:100%" type="text" size="35" value="[content_block id=\'' . $post_id .  '\' title=\'' . $post->post_title .  '\']" readonly/>';
        break;        
      default: 
        break;
    }
  }  
}

new Content_Block();
