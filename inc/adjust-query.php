<?php

// Give tools to adjust wordpress queries
function fictional_university_adjust_query( $query ) {
  // Adjusting past events
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

  // $query->set( 'posts_per_page', 1 ); // Will make all loops returns 1 post, even admin screens

  // Adjust programs archive
  if ( !is_admin() && is_post_type_archive( 'program' ) && $query->is_main_query() ) {
     $query->set( 'orderby', 'title' );
     $query->set( 'order', 'ASC' );
     $query->set( 'posts_per_page', -1 );
  }

  // Adjust campuses archive
  if ( !is_admin() && is_post_type_archive( 'campus' ) && $query->is_main_query() ) {
    $query->set( 'posts_per_page', -1 );
 }
}

add_action( 'pre_get_posts', 'fictional_university_adjust_query' );