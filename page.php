<?php

use Inter\Twig as Twig;

// Post Object
global $post;
$pagename = get_query_var("pagename");

$check_host = $_SERVER['SERVER_NAME'];

// Page data
$page_data = Inter\API::get_page($post->ID);
$feat_img_obj = !empty($page_data["featured_media"]) ? Inter\API::get_featImg_obj($page_data["featured_media"]) : null;
$header_url = $feat_img_obj !== null ? $feat_img_obj["source_url"] : null;
// Reset post data back to post query - above get_featImg_obj API request modifies $post global var
wp_reset_postdata();

$img_id = get_post_thumbnail_id( $post->ID );
$srcset = wp_get_attachment_image_srcset($img_id, "full");
$sizes = wp_get_attachment_image_sizes($img_id, "full");

// Allow for password protected pages
$password_form = post_password_required() ? get_the_password_form() : '';

// Taxonomy data
$categories = Inter\API::get_category_list();

// 'Get in Touch' Form
$formidable_id = get_option( 'inter-joinus-form-id' );
$formVar = do_shortcode( $formidable_id );

// Hero Title Display
$hero_title_display = get_post_meta($post->ID, '_inter_hero_title_option', true);
$hero_subtitle = get_post_meta($post->ID, '_inter_hero_subtitle_option', true);
$hero_attribution_display = get_post_meta($post->ID, '_inter_hero_attribution_option', true );
$hero_attribution_value = get_post_meta($feat_img_obj['id'], '_attribution', true );

// Data array for twig
$context = array(
  'check_host'               => $check_host,
  'pagename'                 => $pagename,
  'page_data'                => $page_data,
  'password_form'            => $password_form,
  'header_url'               => $header_url,
  'feat_img'                 => $feat_img_obj,
  'srcset'		               => $srcset,
  'sizes'		                 => $sizes,
  'formVar'                  => $formVar,
  'hero_title_display'       => $hero_title_display,
  'hero_subtitle'            => $hero_subtitle,
  'hero_attribution_display' => $hero_attribution_display,
  'hero_attribution_value'   => $hero_attribution_value,
  'formVar'                  => $formVar,
  'category_list'            => $categories
);

echo Twig::render( array( "pages/page-" . $pagename . ".twig", "page.twig" ), $context );
