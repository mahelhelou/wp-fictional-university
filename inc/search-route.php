<?php
// Create Custom API URL
function fictional_university_custom_rest_url() {
  register_rest_route( 'university/v1', 'search', array(
    'methods' => WP_REST_SERVER::READABLE, // or 'GET'
    'callback' => 'fictional_university_search_results'
  ) );
}

// (TEST) 'localhost:3000/wp-json/university/v1/search'
function fictional_university_search_results( $data ) {
  // return 'Congratulations! You created a route.';
  // YAY: we don't have to write getJSON request. We use wp core api and it will do its job to convert data in raw json data
  // return array( 'Red', 'Green', 'Blue', 'Yellow' );

  // This isn't a valid JS, but PHP converts it to javascript object
  /* return array(
    'cat' => 'meow',
    'dog' => 'bark'
  ); */

  $mainQuery = new WP_Query( array(
    // 'post_type' => 'professor',
    'post_type' => array( 'post', 'page', 'professor', 'program', 'campus', 'event' ),
    // 's' => 'Barksalot' // Static
    's' => sanitize_text_field( $data[ 'term' ] )
  ) );

  $results = array(
    'generalInfo' => array(),
    'professors' => array(),
    'programs' => array(),
    'campuses' => array(),
    'events' => array()
  );
  // What data to push in our own REST API
  while ( $mainQuery->have_posts() ) {
    $mainQuery->the_post();
    // array_push( $professorResults, 'hello' ); // (TEST)

    if ( get_post_type() == 'post' || get_post_type() == 'page' ) {
      array_push( $results[ 'generalInfo' ], array(
        'title' => get_the_title(),
        'url' => get_the_permalink(),
        'ID' => get_the_ID()
      ) );
    }

    if ( get_post_type() == 'professor') {
      array_push( $results[ 'professors' ], array(
        'title' => get_the_title(),
        'url' => get_the_permalink(),
        'ID' => get_the_ID()
      ) );
    }

    if ( get_post_type() == 'program') {
      array_push( $results[ 'programs' ], array(
        'title' => get_the_title(),
        'url' => get_the_permalink(),
        'ID' => get_the_ID()
      ) );
    }

    if ( get_post_type() == 'campus') {
      array_push( $results[ 'campuses' ], array(
        'title' => get_the_title(),
        'url' => get_the_permalink(),
        'ID' => get_the_ID()
      ) );
    }

    if ( get_post_type() == 'event') {
      array_push( $results[ 'events' ], array(
        'title' => get_the_title(),
        'url' => get_the_permalink(),
        'ID' => get_the_ID()
      ) );
    }
  }

  // return $professors->posts;
  return $results;
}

add_action( 'rest_api_init', 'fictional_university_custom_rest_url' );