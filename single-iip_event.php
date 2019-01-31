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
$meta_array = get_post_meta( $id, '_iip_event_meta' );
$event_thumbnail = get_the_post_thumbnail_url( $id, 'full' );
$post_meta = $meta_array[0];

$title = $post_meta['title'];
$thumbnail = !empty( $event_thumbnail ) ? $event_thumbnail : '';
$date = date( 'l, M. j, Y', strtotime( $post_meta['date'] ) );
$end_date = ( $post_meta['multiDay'] == true ) ? ' - ' . date( 'l, M. j, Y', strtotime( $post_meta['endDate'] ) ) : '';
$timezone = ( $post_meta['timezone'] ) ? ' ' . $post_meta['timezone'] : '';
$time = ( $post_meta['hasTime'] == true ) ? ' at ' . $post_meta['time'] . ' - ' . $post_meta['endTime'] . $timezone : '';
$language = ( $post_meta['language'] ) ? $post_meta['language'] : '';
$organizer = ( $post_meta['organizer'] ) ? $post_meta['organizer'] : '';
$link = ( $post_meta['link'] ) ? ( $post_meta['link'] ) : '';
$description = ( $post_meta['description'] ) ? $post_meta['description'] : '';
$speakers = ( $post_meta['speakers'] ) ? $post_meta['speakers'] : '';
$materials = ( $post_meta['materialsLink'] ) ? $post_meta['materialsLink'] : '';
$contact['method'] = ( $post_meta['contactMethod'] ) ? ' at ' . $post_meta['contactMethod'] : '';
$contact['name'] = ( $post_meta['contact'] ) ? $post_meta['contact'] : '';

$context = array(
  'title'       => $title,
  'thumbnail'   => $thumbnail,
  'date'        => $date,
  'end_date'    => $end_date,
  'time'        => $time,
  'language'    => $language,
  'organizer'   => $organizer,
  'link'        => $link,
  'description' => $description,
  'speakers'    => $speakers,
  'materials'   => $materials,
  'contact'     => $contact
);

// Render template passing in data array
echo Twig::render('single-iip_event.twig', $context);