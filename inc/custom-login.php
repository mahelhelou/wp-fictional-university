<?php

function custom_login_screen() {
  return esc_url( site_url( '/' ) );
}

add_action( 'login_headerurl', 'custom_login_screen' );

function login_css() {
  wp_enqueue_style( 'google-roboto-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );

  wp_enqueue_style( 'fictional-university-styles', get_stylesheet_uri(), NULL, microtime() );
}

add_action( 'login_enqueue_scripts', 'login_css' );

function login_header_title() {
  return get_bloginfo( 'name' );
}

add_filter( 'login_headertitle', 'login_header_title' );