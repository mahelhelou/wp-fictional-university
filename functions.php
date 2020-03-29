<?php

// Load Fictional University Assets
function fictional_university_assets() {
   // Load fonts
   wp_enqueue_style( 'google-roboto-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
   wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );

   // Load styles
   wp_enqueue_style( 'fictional_university_styles', get_stylesheet_uri(), NULL, microtime() );

   // Load scripts
   wp_enqueue_script( 'fictional_university_scripts', get_template_directory_uri() . '/js/scripts-bundled.js', NULL, microtime(), true );
}

add_action( 'wp_enqueue_scripts', 'fictional_university_assets' );

// Fictional University Features
function fictional_university_features() {
   // Title tag support
   add_theme_support( 'title-tag' );

   // Creating dynamic menus
   register_nav_menus( array(
      'primary_menu' => 'Primary Menu',
      'footer_menu_1' => 'Footer Menu One',
      'footer_menu_2' => 'Footer Menu Two'
   ) );
}

add_action( 'after_setup_theme', 'fictional_university_features' );

// In real world, move this function to 'mu-plugins/fictional_university_post_types' file
function fictional_university_post_types() {
   // Event post type
   register_post_type( 'event', array(
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

   // Program post type
   register_post_type( 'program', array(
   'supports' => array( 'title', 'editor' ),
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
}

add_action( 'init', 'fictional_university_post_types' );

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
}

add_action( 'pre_get_posts', 'fictional_university_adjust_query' );