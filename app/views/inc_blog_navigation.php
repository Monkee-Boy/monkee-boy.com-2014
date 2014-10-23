<?php
// need to get header image from CMS
//$header_img = $is_post? '/assets/blog-post-featured.png': '/assets/blog-landing-featured.jpg';
?>
<header role="banner" class="blog-header blur-image <?php if(!$is_post) echo ' listing-page'; ?>">
  <img src="<?php echo $header_img; ?>" alt="" class="image-bg">
  <nav class="blog-nav row" role="navigation">
    <a href="#" class="blog-logo">The Blog</a>
    <ul class="menu-lite main-menu">
      <li class="primary"><a href="#">Home</a></li>
      <li class="primary"><a href="#">Portfolio</a></li>
      <li class="primary"><a href="#">Request a quote</a></li>
    </ul>
  </nav>

  <?php //if($is_post): ?>
  <div class="post-header row">
    <h1>Once Upon a Time There Was a Website</h1>
    <img src="/assets/troop-autumn-default.jpg" alt="Autumn Hutchins" class="author-pic">
    <span class="source">By Autumn Hutchins</span>
    <ul class="menu-lite">
      <li>Category</li>
      <li>3 Comments</li>
      <li>May 29th 2014</li>
    </ul>
  </div>
  <?php //endif; ?>

</header>
<div class="mobile-header mobile-blog-header">
  <img src="/images/logo-horizontal.png" alt="Monkee-Boy Web Design" class="mobile-logo">
  <a href="#" class="mobile-menu-trigger">Menu</a>
  <div class="blog-banner">The Blog</div>
</div>
