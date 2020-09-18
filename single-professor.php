<?php get_header();

  while(have_posts()) {
    the_post();
    pageBanner(); ?>

    <!-- Page banner div deleted from here -->

    <div class="container container--narrow page-section">

      <div class="generic-content">
        <div class="row group">

          <div class="one-third">
            <!-- <?php the_post_thumbnail(); // original size that harms bandwidth ?> -->
            <?php the_post_thumbnail('professor-portrait'); ?>
          </div>

          <div class="two-thirds">

            <span class="like-box">
              <i class="fa fa-heart-o" aria-hidden="true"></i>
              <i class="fa fa-heart" aria-hidden="true"></i>
              <span class="like-count">3</span>
            </span>

            <?php the_content(); ?>
          </div>

        </div>
      </div>

      <?php
        // Linking events to related programs
        // 'related_programs' is a custom field that lives in 'Related Programs' group
        $relatedPrograms = get_field('related_programs');
        // To know what lives inside 'related_programs' custom field
        // print_r( $relatedPrograms ); // returns array

        // Show related programs for only events that have a related programs value

        if ($relatedPrograms) {
          echo '<hr class="section-break">';
          echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
          echo '<ul class="link-list min-list">';
          foreach($relatedPrograms as $program) { ?>
            <!-- // Each item in the array is a Post Object -->
            <!-- // the_title(); // this works for default loop, main query -->
            <!-- // echo get_the_title( $program ); // BiologyMath -->
            <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
          <?php }
          echo '</ul>';
        }

      ?>

    </div>

  <?php }

  get_footer();

?>