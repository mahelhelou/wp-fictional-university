# WORDPRESS API

- To grab the content from DB, javascipt doesn't do anything
- Fetching 10 recent posts: `http://localhost:3000/wp-json/wp/v2/posts`
- Fetching 10 recent pages: `http://localhost:3000/wp-json/wp/v2/pages`j
- Grab one post per page: `http://localhost:3000/wp-json/wp/v2/posts?per_page=1`
- Grab post with specific id: `http://localhost:3000/wp-json/wp/v2/posts/34`
- Specific post that contains (Award): `http://localhost:3000/wp-json/wp/v2/posts?search=award`

## Start using postmain software
- Download Postman program
- Choose `GET` to grab data
- Press send button