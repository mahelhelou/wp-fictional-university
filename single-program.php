<?php get_header(); ?>

<?php
   while( have_posts() ) {
      the_post();
      pageBanner();
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
            <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link( 'program' ); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a>
               <span class="metabox__main"><?php the_title(); ?></span></p>
         </div>

         <!-- <div class="generic-content"><?php the_content(); ?></div> -->
         <!-- To prevent search_overlay from outputing body content related to other program. For example, if we search for 'Math' and in the bioloty program body content 'The biology works with Math closely', the result of search will output Biology program and it's professors. This is not what we want! -->
         <div class="generic-content"><?php the_field( 'main_body_content' ); ?></div>

         <!-- Linking upcoming events to viewed program, but without creating another 'Related Events' custom field group, use front-page.php already built custom query -->
         <?php
          $relatedProfessors = new WP_Query( array(
            'post_type' => 'professor',
            'posts_per_page' => -1, // -1 show all posts
            'orderby' => 'title',
            'order' => 'ASC', // DESC, ASC
            'meta_query' => array(
              // Think of array as a filter that returns something you specifiy
              // Only show events that are greater than today date
              array(
                 'key' => 'related_programs',
                 'compare' => 'LIKE',
                 'value' => '"' . get_the_ID() . '"' // give the id of '12', not 12
              )
            )
          ) );

          if ( $relatedProfessors->have_posts() ) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';

            while ( $relatedProfessors->have_posts() ) {
              $relatedProfessors->the_post(); ?>
              <li class="professor-card__list-item">
                <a class="professor-card" href="<?php the_permalink(); ?>">
                  <!-- <img src="<?php the_post_thumbnail_url(); // the original image size, high resolution that harms the bandwidth ?>" alt="" class="professor-card__image"> -->

                  <img src="<?php the_post_thumbnail_url( 'professor-landscape' ); // the new size ?>" alt="" class="professor-card__image">
                  <span class="professor-card__name"><?php the_title(); ?></span>
                </a>
              </li>

            <?php }
              echo '</ul>';
            }
              wp_reset_postdata();

          // echo home page events in single-program.php
          $today = date( 'Ymd' );
          $homePageEvents = new WP_Query( array(
            'post_type' => 'event',
            'posts_per_page' => 2, // -1 show all posts
            'meta_key' => 'event_date',
            // [title, post_date, rand for ajax idea] // -1 for all posts
            'orderby' => 'meta_value_num',
            'order' => 'ASC', // DESC, ASC
            'meta_query' => array(
              // Think of array as a filter that returns something you specifiy
              // Only show events that are greater than today date
              array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
              ),
              array(
                 'key' => 'related_programs',
                 'compare' => 'LIKE',
                 'value' => '"' . get_the_ID() . '"' // give the id of '12', not 12
              )
            )
          ) );

          if ( $homePageEvents->have_posts() ) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';

            while ( $homePageEvents->have_posts() ) {
              $homePageEvents->the_post();
              get_template_part( 'template-parts/content-event' );

            }
          }
            wp_reset_postdata();

            $relatedCampuses = get_field( 'related_campus' );

            if ( $relatedCampuses ) {
              echo '<hr class="section-break">';
              echo '<h2 class="headline headline--medium">' . get_the_title() . ' is Available At These Campuses!</h2>';

              echo '<ul class="min-list link-list">';
              foreach ( $relatedCampuses as $campus ) {
                ?> <li><a href="<?php echo get_the_permalink( $campus ); ?>"><?php echo get_the_title( $campus ); ?></a></li> <?php
              }
              echo '</ul>';
            }
        ?>
      </div>

   <?php }

get_footer(); ?>