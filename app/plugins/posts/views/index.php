<?php $this->tplDisplay("inc_header.php", ['menu'=>'blog']); ?>

  <?php if(!empty($aLatestPost)) { ?>
  <article class="row featured-post">
    <div class="header-meta">
      <span class="bg" style="background-image:url(/uploads/posts/<?php echo $aLatestPost['featured_image']; ?>)"></span>
      <div class="title">
        <h1><?php echo $aLatestPost['title']; ?></h1>
        <span class="source">By <?php echo $aLatestPost['author']['name']; ?></span>
      </div>
    </div>
    <div class="excerpt">
      <ul class="menu-lite">
        <?php if(!empty($aLatestPost['categories'])) { ?><li><?php echo $aLatestPost['categories'][0]['name']; ?></li><?php } ?>
        <li><a href="<?php echo $aLatestPost['url']; ?>#disqus_thread"></a></li>
        <li><?php echo date('F d, Y', $aLatestPost['publish_on']); ?></li>
      </ul>

      <?php echo $aLatestPost['excerpt']; ?>
      <a href="<?php echo $aLatestPost['url']; ?>" class="more-link">Read the full article</a>
    </div>
  </article><!-- /.featured-post -->
  <?php } ?>

  <?php if(!empty($aCategories)) { ?>
  <div class="row blog-list">
    <div class="full filter-bar">
      <label for="category">To filter recent posts please</label>
      <div class="select-box">
        <form name="category" method="get" action="/blog/">
          <select name="category" id="category">
            <option value="">Select a Category</option>
            <?php foreach($aCategories as $aCategory) { ?>
              <option value="<?php echo $aCategory['id']; ?>"<?php if($aCategory['id'] == $_GET['category']) { ?> selected="selected"<?php } ?>><?php echo $aCategory['name']; ?></option>
            <?php } ?>
          </select>
        <form>
      </div>
    </div><!-- /.filter-bar -->
    <?php } ?>

    <?php if(!empty($aPosts)) { foreach($aPosts as $k=>$aPost) { ?>
    <div class="one-third post-panel" data-text-align="center">
      <div class="post-panel-inside">
        <a href="<?php echo $aPost['url']; ?>" title="Permalink for <?php echo $aPost['title']; ?>"><img src="/uploads/posts/<?php echo $aPost['listing_image']; ?>" alt="<?php echo $aPost['title']; ?>"></a>
        <h4><a href="<?php echo $aPost['url']; ?>" title="Permalink for <?php echo $aPost['title']; ?>"><?php echo $aPost['title']; ?></a></h4>
      </div> <!-- /.post-panel-inside -->
    </div> <!-- /.one-third.post-panel -->
    <?php } } ?>
  </div><!-- /.blog-list -->

  <div class="paging row">
    <div class="full">
      <a href="#" class="load-more button">Load More!</a>
    </div> <!-- /.full -->
  </div> <!-- /.paging.row -->

  {footer}
  <script>
  <?php if(!empty($aCategory)) { ?>
  $('html, body').animate({
    scrollTop: ($('.blog-list').offset().top)
  }, 500);
  <?php } ?>

  $(function(){
    $('select[name=category]').change(function(){
      $('form[name=category]').submit();
    });
  });

  /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
  var disqus_shortname = 'monkeeboyblog'; // required: replace example with your forum shortname

  /* * * DON'T EDIT BELOW THIS LINE * * */
  (function () {
    var s = document.createElement('script'); s.async = true;
    s.type = 'text/javascript';
    s.src = '//' + disqus_shortname + '.disqus.com/count.js';
    (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
  }());
  </script>
  {/footer}

  <?php $this->tplDisplay("inc_footer.php"); ?>
