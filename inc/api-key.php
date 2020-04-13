<?php

// Add API Key
function fictional_university_api_key( $api ) {
  // $api[ 'key' ] = 'AIzaSyC1YrXh25wcrvknWQaF7dNWEDD2ATDzXFE';
  $api[ 'key' ] = 'AIzaSyCMZ9-DGyNDrT7MvFAYhuaTZnq-XYDyl7g';
  return $api;
}

add_filter( 'acf/fields/google_map/api', 'fictional_university_api_key' );