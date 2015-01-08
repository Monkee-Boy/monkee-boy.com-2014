<?php
if($menu === 'blog-post') {
  $header_image = '/uploads/posts/'.$aPost['featured_image'];
} else {
  $header_image = '/images/blog-landing-featured.jpg';
}
?>
<header role="banner" class="blog-header blur-image<?php if($menu === 'blog') { echo ' listing-page'; } ?>">
  <img src="<?php echo $header_image; ?>" alt="" class="image-bg">
  <nav class="blog-nav row" role="navigation">
    <a href="/blog/" class="blog-logo">The Blog</a>
    <ul class="menu-lite main-menu">
      <li class="primary"><a href="/">Home</a></li>
      <li class="primary"><a href="/the-work/">Portfolio</a></li>
      <li class="primary"><a href="/contact/work-with-us/">Request a quote</a></li>
    </ul>
  </nav>

  <?php if($menu === 'blog-post' && !empty($aPost)) { ?>
    <div class="post-header row">
      <h1><?php echo $aPost['title']; ?></h1>
      <img src="/uploads/troop/<?php echo $aPost['author']['photo']; ?>" alt="<?php echo $aPost['author']['name']; ?>" class="author-pic">
      <span class="source">By <?php echo $aPost['author']['name']; ?></span>
      <ul class="menu-lite">
        <?php if(!empty($aPost['categories'])) { ?><li><?php echo $aPost['categories'][0]['name']; ?></li><?php } ?>
        <li><a href="<?php echo $aPost['url']; ?>#disqus_thread"></a></li>
        <li><?php echo date('F d, Y', $aPost['publish_on']); ?></li>
      </ul>
    </div>
  <?php } ?>
</header>

<div class="mobile-header mobile-blog-header">
  <span class="mobile-logo">Monkee-Boy Web Design</span>
  <a href="#" class="mobile-menu-trigger">Menu</a>
  <div class="blog-banner">The Blog</div>
</div>
