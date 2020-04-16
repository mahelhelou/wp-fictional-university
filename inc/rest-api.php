<?php

// Customizing REST API
function fictional_university_custom_rest() {
  // Add author name to posts, rendered in Search.js file. Add a new field to REST API
  register_rest_field( 'post', 'authorName', array(
     // 'get_callback' => function () { return 'Super amazing author name'; }
     'get_callback' => function () { return get_author_name(); }
  ) );

  register_rest_field( 'note', 'userNoteCount', array(
    // 'get_callback' => function () { return 'Super amazing author name'; }
    'get_callback' => function () { return count_user_posts( get_current_user_id(), 'note' ); }
 ) );

  // You can add custom fields to REST API as many as you want
}

add_action( 'rest_api_init', 'fictional_university_custom_rest' );