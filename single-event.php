<?php get_header(); ?>

<?php
   while( have_posts() ) {
      the_post();
      pageBanner(); // no $args needed
      ?>
      <!-- <div class="page-banner">
         <div class="page-banner__bg-image"
            style="background-image: url(<?php echo get_theme_file_uri( '/images/ocean.jpg' ); ?>);"></div>
         <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
               <p>DON'T FORGET TO MAKE MY DYNAMTIC LATOR ON!</p>
            </div>
         </div>
      </div> -->

      <div class="container container--narrow page-section">
         <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link( 'event' ); ?>"><i class="fa fa-calendar" aria-hidden="true"></i> All Events</a>
               <span class="metabox__main"><?php the_title(); ?></span></p>
         </div>

         <div class="generic-content"><?php the_content(); ?></div>

         <?php
            // Linking events to related programs
            // 'related_programs' is a custom field that lives in 'Related Programs' group
            $relatedPrograms = get_field( 'related_programs' );
            // To know what lives inside 'related_programs' custom field
            // print_r( $relatedPrograms ); // returns array

            // Show related programs for only events that have a related programs value

            if ( $relatedPrograms ) {
               echo '<hr class="section-break">';
               echo '<h2 class="headline headline--medium">Related Program(s)</h2>';
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