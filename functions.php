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