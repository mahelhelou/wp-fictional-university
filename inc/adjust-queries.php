<?php

/**
 * Give tools to adjust wordpress queries
 * Because we're in the archive event template, we don't break the normal WP Query by writing a new custom query!
 * WP Query renders different output based on file template
 * Pagination for all posts with the following function will work without extra hassle
 * This query affects all front-end and admin area for showing posts (Posts -> All posts)
 */
function fictional_university_adjust_queries( $query ) {
  // Events
  if ( !is_admin() && is_post_type_archive( 'event' ) && $query->is_main_query() ) {
    $today = date( 'Ymd' );
    $query->set( 'meta_key', 'event_date' );
    $query->set( 'orderby', 'meta_value_num' );
    $query->set( 'order', 'ASC' );
    $query->set( 'meta_query', array(
      array(
        'key' => 'event_date',
        'compare' => '>=',
        'value' => $today,
        'type' => 'numeric'
      )
    ) );
  }

  /**
   * Programs query
   * List all programs and order programs by title
   */
  if ( !is_admin() && is_post_type_archive( 'program' ) && $query->is_main_query() ) {
    $query->set( 'orderby', 'title' );
    $query->set( 'order', 'ASC' );
    $query->set( 'posts_per_page', -1 );
  }

  // Courses
  if ( !is_admin() && is_post_type_archive( 'campus' ) && $query->is_main_query() ) {
    $query->set( 'posts_per_page', -1 );
 }
}

add_action( 'pre_get_posts', 'fictional_university_adjust_queries' );