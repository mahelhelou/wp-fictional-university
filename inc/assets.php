<?php

// Load Fictional University Assets
function fictional_university_assets() {
  // Load fonts
  wp_enqueue_style( 'google-roboto-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
  wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );

  // Load styles
  wp_enqueue_style( 'fictional-university-styles', get_stylesheet_uri(), NULL, microtime() );

  // Load scripts
  wp_enqueue_script( 'fictional-university-scripts', get_template_directory_uri() . '/js/scripts-bundled.js', NULL, microtime(), true );

  // Localize scripts for dynamic root url
  // View page source, scroll very down. You'll see these info
  wp_localize_script( 'fictional-university-scripts', 'fictionalUniversityData', array(
     'root_url' => get_site_url(),
     // 'sky' => 'blue',
     // 'grass' => 'green'
  ) );
}

add_action( 'wp_enqueue_scripts', 'fictional_university_assets' );