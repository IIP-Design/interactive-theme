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
$post_meta = $meta_array[0];

$title = $post_meta['title'];
$thumbnail = ( $post_meta['thumbnail'] ) ? $post_meta['thumbnail'] : '';
$date = date( 'l, M. j, Y', strtotime( $post_meta['date'] ) );
$end_date = ( $post_meta['multiDay'] == true ) ? ' - ' . date( 'l, M. j, Y', strtotime( $post_meta['endDate'] ) ) : '';
$timezone = ( $post_meta['timezone'] ) ? ' ' . $post_meta['timezone'] : '';
$time = ( $post_meta['hasTime'] == true ) ? ' at ' . $post_meta['time'] . ' - ' . $post_meta['endTime'] . $timezone : '';
$language = ( $post_meta['language'] ) ? '<p><strong>Language:</strong> ' . $post_meta['language'] . '</p>' : '';
$organizer = ( $post_meta['organizer'] ) ? '<p><strong>Organizer:</strong> ' . $post_meta['organizer'] . '</p>' : '';
$link = ( $post_meta['link'] ) ? '<p><strong>Link:</strong> <a href="' . $post_meta['link'] . '">' . $post_meta['link'] . '</a></p>' : '';
$description = ( $post_meta['description'] ) ? '<h3>Description:</h3><p>' . $post_meta['description'] . '</p>' : '';
$speakers = ( $post_meta['speakers'] ) ? '<h3>Speakers:</h3><p>' . $post_meta['speakers'] . '</p>' : '';
$materials_link = ( $post_meta['materialsLink'] ) ? '<a class="ui button" href="' . $post_meta['materialsLink'] . '" target="_blank">See all materials on Box ></a>' : '';
$materials = ( $materials_link ) ? '<h3>Promotional Materials:</h3><p>' . $materials_link . '</p>' : '';
$contact_method = ( $post_meta['contactMethod'] ) ? ' at ' . $post_meta['contactMethod'] : '';
$contact_name = ( $post_meta['contact'] ) ? $post_meta['contact'] : '';
$contact = ( $contact_name ) ? '<strong>Questions about this event?</strong><strong>Reach out to ' . $contact_name . $contact_method . '</strong>' : '';

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