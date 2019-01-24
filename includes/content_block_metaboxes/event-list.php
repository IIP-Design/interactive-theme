<?php

/*************************************************************************************************
 *                                        EVENT LIST                                             *
 *************************************************************************************************/

// Query for events
$args = array(
 	'post_type'  => 'iip_event',
 	'posts_per_page' => '-1'
 );

$all_events = new WP_Query( $args );
wp_reset_postdata();

$events_select_menu = array();

foreach ( $all_events->posts as $event ) {
 	$events_select_menu[$event->ID] = $event->post_title;
 }

// Event List Metabox
$cb_events_list = new_cmb2_box( array(
  'id'           =>  $prefix . 'cb_events_list',
  'title'        => __( 'Event List', 'inter' ),
  'object_types' => array( 'content_block' ),
  'priority'     => 'low'
));

$cb_events_list->add_field( array(
  'id'      => $prefix . 'cdp_event_list_layout',
  'name'    => __( 'Layout', 'inter' ),
  'desc'    => 'Layout patterns for the list of events',
  'type'    => 'radio',
  'default' => '3_column_grid',
  'options' => array(
    '3_column_grid'     => __( 'Three column grid of events', 'inter' ),
    'featured_vertical' => __( 'Featured event with a vertical list of additional event titles', 'inter' ),
    'featured_sidebar'  => __( 'Featured event with a right sidebar of additional event titles (best with 6 to 9 events)', 'inter' ),
    'featured_block'    => __( 'Featured event with a right sidebar of two smaller featured events', 'inter' )
  ),
));

$cb_events_list_group = $cb_events_list->add_field( array(
	'id'          => 'cb_events_list_repeat_group',
	'type'        => 'group',
	'description' => __( 'Select Events To be Displayed' ),
  'options'     => array(
		'group_title'   => __( 'Event {#}', 'inter' ),
		'add_button'    => __( 'Add Another Event', 'inter' ),
		'remove_button' => __( 'Remove Event', 'inter' ),
		'sortable'      => true
	),
) );

$cb_events_list->add_group_field( $cb_events_list_group, array(
	'name' => 'Select Event',
	'id'  => $prefix . 'select_event',
	'type' => 'select',
	'default' => 'center',
	'options' => $events_select_menu
) );

$cb_events_list->add_group_field( $cb_events_list_group, array(
	'name' => 'Related Link',
	'id'  => $prefix . 'related_link',
	'type' => 'related_link',
	'options' => $events_select_menu
) );
