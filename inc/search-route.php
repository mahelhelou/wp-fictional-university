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
        'ID' => get_the_ID(),
        'postType' => get_post_type(),
        'authorName' => get_the_author()
      ) );
    }

    if ( get_post_type() == 'professor') {
      array_push( $results[ 'professors' ], array(
        'title' => get_the_title(),
        'url' => get_the_permalink(),
        'ID' => get_the_ID(),
        'image' => get_the_post_thumbnail_url( 0, 'professor-landscape' ) // 0 = current post
      ) );
    }

    if ( get_post_type() == 'program') {
      $relatedCampuses = get_field( 'related_campus' );

      if ( $relatedCampuses ) {
        foreach ( $relatedCampuses as $campus ) {
          array_push( $results[ 'campuses' ], array(
            'title' => get_the_title( $campus ),
            'url' => get_the_permalink( $campus )
          ) );
        }
      }

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
      $eventDate = new DateTime( get_field( 'event_date' ) );
      $description = null;

      if ( has_excerpt() ) {
        $description = get_the_excerpt();
      } else {
        $description = wp_trim_words( get_the_content(), 18 );
      }

      array_push( $results[ 'events' ], array(
        'title' => get_the_title(),
        'url' => get_the_permalink(),
        'ID' => get_the_ID(),
        'month' => $eventDate->format( 'M' ),
        'day' => $eventDate->format( 'd' ),
        'description' => $description
      ) );
    }
  }

  if ( $results[ 'programs' ] ) {
    // Implement custom search logic by relationship
    $programsMetaQuery = array( 'relation' => 'OR' );

    foreach ( $results[ 'programs' ] as $item ) {
      array_push( $programsMetaQuery, array(
        'key' => 'related_programs',
        'compare' => 'LIKE',
        // 'value' => '"49"' // hard coded value
        // If only one math in the programs array, pick the first result that mathes your search! But if multiple!
        // 'value' => '"' . $results[ 'programs' ][0]['ID'] . '"'
        'value' => '"' . $item[ 'ID' ] . '"'
      ) );
    }

    $programsRelationshipQuery = new WP_Query( array(
      'post_type' => array( 'professor', 'event' ),
      'meta_query' =>  $programsMetaQuery
    ) );

    while ( $programsRelationshipQuery->have_posts() ) {
      $programsRelationshipQuery->the_post();

      if ( get_post_type() == 'professor') {
        array_push( $results[ 'professors' ], array(
          'title' => get_the_title(),
          'url' => get_the_permalink(),
          'ID' => get_the_ID(),
          'image' => get_the_post_thumbnail_url( 0, 'professor-landscape' )
        ) );
      }

      if ( get_post_type() == 'event') {
        $eventDate = new DateTime( get_field( 'event_date' ) );
        $description = null;

        if ( has_excerpt() ) {
          $description = get_the_excerpt();
        } else {
          $description = wp_trim_words( get_the_content(), 18 );
        }

        array_push( $results[ 'events' ], array(
          'title' => get_the_title(),
          'url' => get_the_permalink(),
          'ID' => get_the_ID(),
          'month' => $eventDate->format( 'M' ),
          'day' => $eventDate->format( 'd' ),
          'description' => $description
        ) );
      }
    }

    // Remove duplicates of results
    // array_values: remove the index from JSON object
    $results[ 'professors' ] = array_values( array_unique( $results[ 'professors' ], SORT_REGULAR ) );

    $results[ 'events' ] = array_values( array_unique( $results[ 'events' ], SORT_REGULAR ) );
  }

  // return $professors->posts;
  return $results;
}

add_action( 'rest_api_init', 'fictional_university_custom_rest_url' );