# FEATURES

- Loading scripts and styles
- Show admin bar: `wp_footer()`
- Print images: `echo get_theme_file_uri('/images/xyz.ext')`
- Print site url: `echo site_url()`

## `pageBanner();`

- HTML Page Banner

```html
<div class="page-banner">
  <div
    class="page-banner__bg-image"
    style="background-image: url(<?php echo get_theme_file_uri( '/images/ocean.jpg' ); ?>);"
  ></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title"><?php the_title(); ?></h1>
    <div class="page-banner__intro">
      <p>DON'T FORGET TO MAKE MY DYNAMTIC LATOR ON!</p>
    </div>
  </div>
</div>
```

- Static `pageBanner()`

```php
<?php
// Array provided bellow used in the case of STATIC data not DYNAMIC data from DB
  pageBanner( /* array(
     'title' => 'Hello, title goes here',
     'subtitle' => 'Hi, subtitle goes here',
     'photo' => 'https://images.unsplash.com/photo-1544198365-f5d60b6d8190?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=750&q=80'
  ) */);
  ?>
```
