<?php

// Redirect subscriber accounts out of admin page and onto homepage
function redirect_subscribers_to_frontend() {
  $currentSubscriber = wp_get_current_user();

  // If the current user only have 1 role and the role is 'subscriber'
  if ( count( $currentSubscriber->roles ) == 1 && $currentSubscriber->roles[0] == 'subscriber' ) {
    wp_redirect( site_url( '/' ) );
    exit;
  }
}

add_action( 'admin_init', 'redirect_subscribers_to_frontend' );

// Hide admin bar from subscribers
function no_subscribers_admin_bar() {
  $currentSubscriber = wp_get_current_user();

  // If the current user only have 1 role and the role is 'subscriber'
  if ( count( $currentSubscriber->roles ) == 1 && $currentSubscriber->roles[0] == 'subscriber' ) {
    show_admin_bar( false );
  }
}

add_action( 'wp_loaded', 'no_subscribers_admin_bar' );