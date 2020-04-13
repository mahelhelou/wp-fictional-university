<?php

/**
 * pageBanner function VS. get_template_part() function
 * if you want to make something more dynamic with $args, use function
 * if the file or <div> is just a content, use get_template_part()
*/

// My prefered functions' names is prefixing with 'fictional_university_', but in some cases, I kept some names shorter for educational purposes

// Add Page Banner for Pages, Blog Posts and Custom Post Types
function pageBanner( $args = NULL ) {
   // $args: make the function more flexiblle and dynamic
   // $args = NULL: make the $args NOT required, if we not passed $args back to default behaviour (fallback)

   // PHP logic
   if ( !$args[ 'title' ] ) {
      // If we don't passed title as arg, get the title from default wordpress title
      $args[ 'title' ] = get_the_title();
   }

   if ( !$args[ 'subtitle' ] ) {
      $args[ 'subtitle' ] = get_field( 'page_banner_subtitle' );
   }

   if ( !$args[ 'photo' ] ) {
      // If there's a photo in custom field
      if ( get_field( 'page_banner_background_image' ) ) {
         $args[ 'photo' ] = get_field( 'page_banner_background_image' )['sizes']['page-banner']; // page-banner: the nickname of size we told wordpress to generate
      } else {
         $args[ 'photo' ] = get_theme_file_uri( '/images/ocean.jpg' );
      }
   }

   ?>
   <div class="page-banner">
         <div class="page-banner__bg-image"
         style="background-image: url(<?php echo $args['photo']; ?>);"></div>
      <div class="page-banner__content container container--narrow">
         <h1 class="page-banner__title"><?php echo $args[ 'title' ]; // the_title(); ?><h1>
         <div class="page-banner__intro">
            <p><?php echo $args[ 'subtitle' ]; // the_field( 'page_banner_subtitle' ); ?></p>
         </div>
      </div>
   </div>
<?php }