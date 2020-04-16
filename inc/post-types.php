<?php

// In real world, move this function to 'mu-plugins/fictional_university_post_types' file
function fictional_university_post_types() {
  // Event Post Type
  register_post_type( 'event', array(
  'capability_type' => 'event', // def: 'post', to give unique previliges
  'map_meta_cap' => true,
  'supports' => array( 'title', 'editor', 'excerpt' ), // for custom fields
  'rewrite' => array( 'slug' => 'events' ), // this is to make events archive as '/events' NOT 'event'
  'has_archive' => true, // To act like a blog of all posts
  'public' => true,
  'labels' => array(
     'name' => 'Events',
     'add_new_item' => 'Add New Event',
     'edit_item' => 'Edit Event',
     'all_items' => 'All Events',
     'singular_name' => 'Event'
  ),
  'menu_icon' => 'dashicons-calendar'
  ) );

  // Program Post Type
  register_post_type( 'program', array(
  'supports' => array( 'title' ), // we removed 'editor'
  'rewrite' => array( 'slug' => 'programs' ),
  'has_archive' => true,
  'public' => true,
  'labels' => array(
     'name' => 'Programs',
     'add_new_item' => 'Add New Program',
     'edit_item' => 'Edit Program',
     'all_items' => 'All Programs',
     'singular_name' => 'Program'
  ),
  'menu_icon' => 'dashicons-awards'
  ) );

  // Professor Post Type
  register_post_type( 'professor', array(
  'show_in_rest' => true,
  'supports' => array( 'title', 'editor', 'thumbnail' ),
  'public' => true,
  'labels' => array(
     'name' => 'Professors',
     'add_new_item' => 'Add New Professor',
     'edit_item' => 'Edit Professor',
     'all_items' => 'All Professors',
     'singular_name' => 'Professor'
  ),
  'menu_icon' => 'dashicons-welcome-learn-more'
  ) );

  // Campus Post Type
  register_post_type( 'campus', array(
      'capability_type' => 'campus', // def: 'post', to give previliges
      'map_meta_cap' => true,
     'supports' => array( 'title', 'editor', 'excerpt' ),
     'rewrite' => array( 'slug' => 'campuses' ),
     'has_archive' => true,
     'public' => true,
     'labels' => array(
     'name' => 'Campuses',
     'add_new_item' => 'Add New Campus',
     'edit_item' => 'Edit Campus',
     'all_items' => 'All Campuses',
     'singular_name' => 'Campus'
     ),
     'menu_icon' => 'dashicons-location-alt'
  ) );

  // Note Post Type
  register_post_type( 'note', array(
   'capability_type' => 'note', // give a new permissions (def permission: inherit from blog post)
   'map_meta_cap' => true,
   'show_in_rest' => true,
   'supports' => array( 'title', 'editor' ),
   'public' => false, // keep it private to users only
   'show_ui' => true, // allow admin to see the post
   'labels' => array(
      'name' => 'Notes',
      'add_new_item' => 'Add New Note',
      'edit_item' => 'Edit Note',
      'all_items' => 'All Notes',
      'singular_name' => 'Note'
   ),
   'menu_icon' => 'dashicons-welcome-write-blog'
   ) );
}

add_action( 'init', 'fictional_university_post_types' );