<?php
   /**
    * A copy from single-event.php file
    */
?>

<?php get_header(); ?>

<?php
   while( have_posts() ) {
      the_post();
      pageBanner(); // call pageBanner DRY function
      ?>
      <!-- <div class="page-banner"> -->
         <!-- For educational purposes, we echo custom fields of 'page_banner_background_image' and 'page_banner_subtitle' in a single file. In real world, we use DRY concept to echo page banner image and title on every single page and post (if any) -->

         <!-- <div class="page-banner__bg-image"
            style="background-image: url(<?php // echo get_theme_file_uri( '/images/ocean.jpg' ); ?>);"></div> -->

            <!-- <div class="page-banner__bg-image"
            style="background-image: url(<?php
               $pageBannerImage = get_field( 'page_banner_background_image' );
               // print_r ($pageBannerImage); // to view all data for this $var
               // echo $pageBannerImage[ 'url' ];
               echo $pageBannerImage[ 'sizes' ][ 'page-banner' ]; // size 'page-banner' comes from functions.php file, the nick name of size we told wordpress to generate
            ?>);"></div> -->

         <!-- <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
               <?php //<p>DON'T FORGET TO MAKE MY DYNAMTIC LATOR ON!</p> ?>
               <p><?php the_field( 'page_banner_subtitle' ); ?></p>
            </div>
         </div>
      </div> -->

      <div class="container container--narrow page-section">
         <div class="row group">
            <div class="one-third">
               <!-- <?php the_post_thumbnail(); // original size that harms bandwidth ?> -->
               <?php the_post_thumbnail( 'professor-portrait' ); ?>
            </div>

            <div class="two-thirds">
               <?php the_content(); ?>
            </div>
         </div>

         <?php
            // Linking events to related programs
            // 'related_programs' is a custom field that lives in 'Related Programs' group
            $relatedPrograms = get_field( 'related_programs' );
            // To know what lives inside 'related_programs' custom field
            // print_r( $relatedPrograms ); // returns array

            // Show related programs for only events that have a related programs value

            if ( $relatedPrograms ) {
               echo '<hr class="section-break">';
               echo '<h2 class="headline headline--medium">Subjects(s) Taught</h2>';
               echo '<ul class="link-list min-list">';
               foreach( $relatedPrograms as $program ) { ?>
                  <!-- // Each item in the array is a Post Object -->
                  <!-- // the_title(); // this works for default loop, main query -->
                  <!-- // echo get_the_title( $program ); // BiologyMath -->
                  <li><a href="<?php echo get_the_permalink( $program ); ?>"><?php echo get_the_title( $program ); ?></a></li>
               <?php }
               echo '</ul>';
            }
         ?>

      </div>

   <?php }
?>

<?php get_footer(); ?>