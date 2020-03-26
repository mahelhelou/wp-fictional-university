# Theme Files and Folders

1. Absolutely needed files

- `index.php`: It's a global fallback file for all files
- `style.css`: Holds meta tags about the theme

2. Extra files

- `screenshot.png` (1200x900)

3. Functionality files

- `index.php` if no:
  - `single.php`
  - `page.php`
- `single.php`: Renders individual post
- `page.php`: Renders single page
- `header.php`
- `footer.php`
- `functions.php`

## `index.php` file

- Create basic WordPress loop
  - Create many posts to experiment with

```php
<?php

while( have_posts() ) {
   the_post(); ?>
   <!-- <h1>Hello</h1> -->
   <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
   <p><?php the_content(); ?></p>
   <hr>
<?php }
```

## `single.php` file

```php
<?php

while( have_posts() ) {
   the_post(); ?>
   <h1><?php the_title(); ?></h1>
   <p><?php the_content(); ?></p>
<?php }
```

## `page.php` file

```php
<?php

while( have_posts() ) {
   the_post(); ?>
   <h1><?php the_title(); ?></h1>
   <p><?php the_content(); ?></p>
<?php }
```

## `header.php` file

```php
<!DOCTYPE html>
<html lang="en">
<head>
   <?php wp_head(); ?>
</head>
<body>
   <h1>Hello, from header file</h1>
```

## `footer.php` file

```php
   <h3>Hello, from footer file</h3>
   <?php wp_footer(); ?>
</body>
</html>
```

## `functions.php` file

```php
// Load Test University assets
function test_university_assets() {
   wp_enqueue_style( 'univ_styles', get_stylesheet_uri(), array(), '1.0', 'all' );
}

add_action( 'wp_enqueue_scripts', 'test_university_assets' );
```