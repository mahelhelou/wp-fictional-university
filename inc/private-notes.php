<?php

// Pay attention to userNoteCount in 'rest-api.php' file

// Force notes that created by subscribers to be private. Just trust server side policy not client side policy data: { status: 'private' }
function makeNotePrivate( $data, $postArray ) {
  // Escape html for user-generated content
  if ( $data[ 'post_type' ] == 'note' ) {
    // Allow users to create 5 posts only
    if ( count_user_posts( get_current_user_id(), 'note' ) > 4 && !$postArray[ 'ID' ] ) {
      die( 'You have reached your notes limit!' );
    }

    $data[ 'post_title' ] = sanitize_text_field( $data[ 'post_title' ] );
    $data[ 'post_content' ] = sanitize_textarea_field( $data[ 'post_content' ] );
  }

  if ( $data[ 'post_type' ] == 'note' && $data[ 'post_status' ] != 'trash' ) {
    $data[ 'post_status' ] = 'private';
  }

  return $data;
}

// By default, this runs for 'update-post' too. You have to make some change
add_filter( 'wp_insert_post_data', 'makeNotePrivate', 10, 2 ); // 10: give the priority of function to be number 10, 2: let the function accepts (2) arguments