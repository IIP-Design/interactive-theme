<?php
/**
 * The template for displaying single event posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @since 1.0
 * @version 1.0
 */

use Inter\Twig as Twig;

$id = get_the_ID();
$post_meta = unserialize( get_post_meta( $id, '_iip_event_meta', true ) );
$event_thumbnail = get_the_post_thumbnail_url( $id, 'full' );
$timezone_obj = ( $post_meta['timezone'] );
$timezone_abbrev = $timezone_obj->abbreviation;

$title = $post_meta['title'];
$thumbnail = !empty( $event_thumbnail ) ? $event_thumbnail : '';
$date = date( 'l, M. j, Y', strtotime( $post_meta['date'] ) );
$end_date = ( $post_meta['multiDay'] == true ) ? ' - ' . date( 'l, M. j, Y', strtotime( $post_meta['endDate'] ) ) : '';
$timezone = ( $timezone_abbrev ) ? ' ' . $timezone_abbrev : '';
$time = ( $post_meta['hasTime'] == true ) ? ' at ' . $post_meta['time'] . ' - ' . $post_meta['endTime'] . $timezone : '';
$details = ( $post_meta['details'] ) ? $post_meta['details'] : '';
$description = ( $post_meta['description'] ) ? $post_meta['description'] : '';
$speakers = ( $post_meta['speakers'] ) ? $post_meta['speakers'] : '';
$materials = ( $post_meta['materials'] ) ? $post_meta['materials'] : '';
$files = ( $post_meta['files'] ) ? ( $post_meta['files'] ) : '';
$contact['method'] = ( $post_meta['contactMethod'] ) ? ' at ' . $post_meta['contactMethod'] : '';
$contact['name'] = ( $post_meta['contact'] ) ? $post_meta['contact'] : '';

$context = array(
  'contact'     => $contact,
  'date'        => $date,
  'description' => $description,
  'details'     => $details,
  'end_date'    => $end_date,
  'files'       => $files,
  'materials'   => $materials,
  'speakers'    => $speakers,
  'thumbnail'   => $thumbnail,
  'time'        => $time,
  'title'       => $title
);

// Render template passing in data array
echo Twig::render('single-iip_event.twig', $context);