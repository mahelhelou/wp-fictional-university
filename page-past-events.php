<?php get_header();
  pageBanner( array(
    'title' => 'Past Events',
    'subtitle' => 'A recap of our past events.'
  ) );
?>

<!-- <div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri( '/images/ocean.jpg' ) ?>); "></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Past Events</h1>
    <div class="page-banner__intro">
      <p>A recap of our past events.</p>
    </div>
  </div>
</div> -->

<div class="container container--narrow page-section">
  <?php
    $today = date( 'Ymd' );
    $pastEvents = new WP_Query( array(
      'post_type' => 'event',
      // 'posts_per_page' => 1, // To test pagination
      'paged' => get_query_var( 'paged', 1 ),
      'meta_key' => 'event_date',
      'orderby' => 'meta_value_num',
      'order' => 'ASC', // DESC, ASC
      'meta_query' => array(
        // Only show events that are greater than today date
        array(
          'key' => 'event_date',
          'compare' => '<',
          'value' => $today,
          'type' => 'numeric'
        )
      )
    ) );

    while( $pastEvents->have_posts() ) {
      $pastEvents->the_post();
      get_template_part( 'template-parts/content-event' );
    }

    /**
     * The default pagination function works only for default WP Query,
     * And we need to customize it for $pastEvents pagination
     */
    echo paginate_links( array(
      'total' => $pastEvents->max_num_pages
    ) );
  ?>
</div>

<?php get_footer(); ?>