<?php get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri( '/images/ocean.jpg' ) ?>); "></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">All Events

   <?php // the_archive_title();
   // These (ifs) gives more control about how to display the date, but considering the _the_archive_title() is better and shorter
   if ( is_category() ) {
      //  echo 'Category name goes here.';
      // single_cat_title();
    }
    if ( is_author() ) {
      //  echo 'Author name goes here';
      // echo 'Posts by '; the_author();
    }

    if ( is_date() ) {
      //  echo 'Date goes here';
    }

    if ( is_month() ) {
      //  echo 'Month posts goes here';
    }

    if ( is_year() ) {
      //  echo 'Year posts goes here';
    }
    ?></h1>
    <div class="page-banner__intro">
      <p>See what is going in our world.</p>
    </div>
  </div>
</div>

<div class="container container--narrow page-section">
<?php
  // You don't have to destroy the default query here, you can edit the order of events dates using `fiction_university_adjust_query' function

  while( have_posts() ) {
   the_post(); ?>
   <div class="event-summary">
      <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
        <span class="event-summary__month"><?php
          // the_field( 'event_date' ); // prints full date
          $eventDate = new DateTime( get_field( 'event_date' ) );
          echo $eventDate->format( 'M' );
        ?></span>
        <span class="event-summary__day"><?php echo $eventDate->format( 'd' ); ?></span>
      </a>
      <div class="event-summary__content">
        <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
        <p><?php echo wp_trim_words( get_the_content(), 18 ); ?> <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
      </div>
   </div>
  <?php }

  // Pagination to other posts
  echo paginate_links();
?>

  <hr class="section-break">

  <p>Looking for a recap of past events? <a href="<?php echo site_url( 'past-events' ); ?>">Check our past events archive.</a></p>
</div>

<?php get_footer(); ?>