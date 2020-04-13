<?php

// Fictional University Features
function fictional_university_features() {
  // Title tag support
  add_theme_support( 'title-tag' );

  // Post thumbnail support
  add_theme_support('post-thumbnails');

  // Add new sizes to wordpress uploaded images
  // We'll use a 'manual image crop' plugin to control from where to crop!
  add_image_size( 'professor-landscape', 400, 260, true ); // crop image from the center
  add_image_size( 'professor-portrait', 480, 650, true ); // crop image from the center
  add_image_size( 'page-banner', 1500, 350, true );

  // add_image_size( 'professor-landscape', 400, array( 'left', 'top' ) ); // if we need more control from where to crop image

  // Creating dynamic menus
  register_nav_menus( array(
     'primary_menu' => 'Primary Menu',
     'footer_menu_1' => 'Footer Menu One',
     'footer_menu_2' => 'Footer Menu Two'
  ) );
}

add_action( 'after_setup_theme', 'fictional_university_features' );