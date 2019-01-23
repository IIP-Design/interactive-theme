<?php

/*************************************************************************************************
 *                                        ACCORDION                                              *
 *************************************************************************************************/

$accordion = new_cmb2_box( array(
  'id'           => $prefix . 'cb_accordion',
  'title'        => __( 'Accordion', 'inter' ),
  'object_types' => array('content_block'),
  'priority'     => 'low'
));

$accordion->add_field( array(
  'name' => 'Accordion Headline (Optional)',
  'id'   => $prefix . 'cb_accordion_headline',
  'type' => 'text'
));

$accordion->add_field( array(
  'name' => 'Accordion Headline Alignment (Optional)',
  'id'   => $prefix . 'cb_accordion_headline_alignment',
  'type' => 'select',
  'default' => 'center',
  'options'          => array(
    'left'           => __( 'Left', 'inter' ),
    'center'         => __( 'Center', 'inter' ),
    'right'          => __( 'Right', 'inter' )
  )
));

$accordion->add_field( array(
  'name'                => 'Select Font & Border Color',
  'desc'              => '',
  'id'                => $prefix . 'cb_accordion_font_color',
  'type'              => 'colorpicker',
  'default'           => '#192856',
  'attributes'          => array(
    'data-colorpicker'  => json_encode( array(
        'border'        => false,
        'palettes'      => array( '#ffffff', '#eeeeee', '#f2d400', '#046b99', '#174f9f', '#192856' )
    ))
  )
));

$accordion_group_field_id = $accordion->add_field( array(
  'id'            => 'accordion_repeat_group',
  'type'          => 'group',
  'description'   => __( 'Add Content Items for Accordion Display' ),
  'options'       => array(
    'group_title'     => __( 'Item {#}', 'inter' ),
    'add_button'      => __( 'Add Another Item', 'inter' ),
    'remove_button'   => __( 'Remove Item', 'inter' ),
    'sortable'        => true
  ),
));

$accordion->add_group_field( $accordion_group_field_id, array(
  'name'  => 'Item Title',
  'id'    => 'item_title',
  'type'  => 'text'
));

$accordion->add_group_field( $accordion_group_field_id, array(
  'name'    => 'Item Content',
  'id'      => 'item_content',
  'type'    => 'wysiwyg'
));