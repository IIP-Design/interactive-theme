<?php

/*************************************************************************************************
*                                       GENERAL FIELDS                                           *
**************************************************************************************************/
$cb_box = new_cmb2_box( array(
  'id'           =>  $prefix . 'cb_box',
  'title'        => __( 'General Fields', 'inter' ),
  'object_types' => array( 'content_block' ),
  'priority'     => 'high',
  'closed'       => false
));

// Add Content Block Title
$cb_box->add_field(  array(
  'name'    => __( 'Block Title', 'inter' ),
  'id'      => $prefix . 'block_title',
  'type'    => 'text' ,
  'desc'    => 'Block title that displays. If nothing is entered then the page title will display'
));

$cb_box->add_field(  array(
  'name'    => __( 'Block Title Size', 'inter' ),
  'id'      => $prefix . 'cb_block_title_size',
  'type'    => 'radio_inline',
  'desc'    => 'Block title size',
  'options' => array(
		'h2'    => __( 'Heading 2', 'inter' ),
		'h3'    => __( 'Heading 3', 'inter' ),
		'h4'    => __( 'Heading 4', 'inter' ),
		'h5'    => __( 'Heading 5', 'inter' )
	),
	'default' => 'h2'
));

// Content block type
$cb_box->add_field( array(
  'name'             => 'Block Type',
    'desc'           => 'Content block type',
    'id'             => $prefix . 'cb_type',
    'type'           => 'select',
    'default'        => 'post_list',
  'options'          => array(
    'accordion'      => __( 'Accordion', 'inter' ),
    'button_links'   => __( 'Button Links', 'inter' ),
    'cta'            => __( 'Call To Action', 'inter' ),
    'media_block'    => __( 'Media Block', 'inter' ),
    'page_list'      => __( 'Page List', 'inter' ),
    'post_list'      => __( 'Post List', 'inter' ),
    'filtered_list'  => __( 'Post List with Filters', 'inter' ),
    'social'         => __( 'Social Icons', 'inter' ),
    'text_block'     => __( 'Text Block', 'inter' )
  )
));

 // Content block background color
 $cb_box->add_field( array(
  'name'                => 'Block Background color',
    'desc'              => '',
    'id'                => $prefix . 'cb_bg_color',
    'type'              => 'colorpicker',
    'default'           => '#ffffff',
  'attributes'          => array(
    'data-colorpicker'  => json_encode( array(
        'border'        => false,
        'palettes'      => array( '#ffffff', '#eeeeee', '#f2d400', '#046b99', '#174f9f', '#192856' )
    ))
  )
));

// Full screen width
$cb_box->add_field( array(
  'name'    => 'Full Screen Width?',
  'id'      => $prefix . 'cb_layout_width',
  'desc'    => '',
  'type'    => 'radio_inline',
  'options' => array(
		'yes'   => __( 'Yes', 'inter' ),
		'no'    => __( 'No', 'inter' )
	),
	'default' => 'yes'
));

// Show block title
$cb_box->add_field( array(
  'name'    => 'Show block title?',
  'id'      => $prefix . 'cb_show_title',
  'desc'    => '',
  'type'    => 'radio_inline',
  'options' => array(
		'yes'   => __( 'Yes', 'inter' ),
		'no'    => __( 'No', 'inter' )
	),
	'default' => 'yes'
));

// Underline title
$cb_box->add_field( array(
  'name'    => 'Underline title?',
  'id'      => $prefix . 'cb_title_underline',
  'desc'    => '',
  'type'    => 'radio_inline',
  'options' => array(
		'yes'   => __( 'Yes', 'inter' ),
		'no'    => __( 'No', 'inter' )
	),
	'default' => 'yes'
));

// Title alignment
$cb_box->add_field( array(
  'name'             => 'Title alignment',
    'desc'           => 'Horizontal alignment of title within block',
    'id'             => $prefix . 'cb_title_alignment',
    'type'           => 'select',
    'default'        => 'left',
  'options'          => array(
    'left'           => __( 'Left', 'inter' ),
    'center'         => __( 'Center', 'inter' ),
    'right'          => __( 'Right', 'inter' )
  )
));

// Title color
$cb_box->add_field( array(
  'name'               => 'Title color',
    'desc'             => 'Content block title font color',
    'id'               => $prefix . 'cb_title_color',
    'type'             => 'colorpicker',
    'default'           => '#192856',
  'attributes'          => array(
    'data-colorpicker'  => json_encode( array(
        'border'        => false,
        'palettes'      => array( '#ffffff', '#eeeeee', '#192856' )
    ))
  )
  ));

// Excerpt alignment
$cb_box->add_field( array(
  'name'            => 'Excerpt alignment',
    'desc'          => 'Horizontal alignment of excerpt within block',
    'id'            => $prefix . 'cb_excerpt_alignment',
    'type'          => 'select',
    'default'       => 'left',
  'options'         => array(
    'left'          => __( 'Left', 'inter' ),
    'center'        => __( 'Center', 'inter' ),
    'right'         => __( 'Right', 'inter' )
  )
));

// Excerpt color
$cb_box->add_field( array(
  'name'                => 'Excerpt color',
    'desc'                => 'Content block excerpt font color',
    'id'                  => $prefix . 'cb_excerpt_color',
    'type'                => 'colorpicker',
    'default'             => '#192856',
  'attributes'          => array(
    'data-colorpicker'  => json_encode( array(
        'border'        => false,
        'palettes'      => array( '#ffffff', '#eeeeee', '#192856' )
    ))
  )
));

// Excerpt font weight
$cb_box->add_field( array(
  'name'            => 'Excerpt font weight',
  'desc'            => 'Excerpt font color',
    'id'              => $prefix . 'cb_excerpt_font_weight',
    'type'            => 'select',
    'default'         => 'Normal',
  'options'         => array(
    '300'           => __( 'Light', 'inter' ),
    '400'           => __( 'Normal', 'inter' ),
    '500'           => __( 'Bold', 'inter' ),
    '700'           => __( 'Heavy', 'inter' )
  )
));

// Remaining text alignment
$cb_box->add_field( array(
  'name'            => 'Text alignment',
    'desc'            => 'Horizontal alignment of remaining text within block',
    'id'              => $prefix . 'cb_text_alignment',
    'type'            => 'select',
    'default'         => 'left',
  'options'         => array(
    'left'          => __( 'Left', 'inter' ),
    'center'        => __( 'Center', 'inter' ),
    'right'         => __( 'Right', 'inter' )
  )
));
