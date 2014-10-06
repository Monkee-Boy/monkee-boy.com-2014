<?php
// need to test if it's blog list page or blog post
// temp test only for template files
$path = $_SERVER['REQUEST_URI'];
$is_post = false;
if (strpos($path,'post') !== false) {
  $is_post = true;
}

// need to get header image from CMS
$header_img = $is_post? '/assets/blog-post-featured.png': '/assets/blog-landing-featured.jpg';
?>
<header role="banner" class="blog-header<?php if(!$is_post) echo ' listing-page'; ?>" style="background-image:url(<?php echo $header_img; ?>)">
  <nav class="blog-nav row" role="navigation">
    <a href="#" class="blog-logo">The Blog</a>
    <ul class="menu-lite">
      <li><a href="#">Home</a></li>
      <li><a href="#">Portfolio</a></li>
      <li><a href="#">Request a quote</a></li>
    </ul>
  </nav>

</header>
