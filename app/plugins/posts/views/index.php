<?php $this->tplDisplay("inc_header.php", ['menu'=>'blog', 'page_title'=>$aContent['title'], 'seo_title'=>$aContent['seo_title'], 'seo_description'=>$aContent['seo_description'], 'seo_keywords'=>$aContent['seo_keywords']]); ?>

  <?php if(!empty($aLatestPost)) { ?>
  <article class="row featured-post">
    <div class="header-meta">
      <a href="<?php echo $aLatestPost['url'] ?>" alt="<?php echo $aLatestPost['title']; ?>">
        <span class="bg" style="background-image:url(/uploads/posts/<?php echo $aLatestPost['featured_image']; ?>)"></span>
        <div class="title">
          <h1><?php echo $aLatestPost['title']; ?></h1>
          <span class="source">By <?php echo $aLatestPost['author']['name']; ?></span>
        </div>
      </a>
    </div>
    <div class="excerpt">
      <?php if(!empty($aLatestPost['categories'])) { ?><h4><?php echo $aLatestPost['categories'][0]['name']; ?></h4><?php } ?>
      <ul class="menu-lite">
        <li><?php echo date('F d, Y', $aLatestPost['publish_on']); ?></li>
        <li><a href="<?php echo $aLatestPost['url']; ?>#disqus_thread"></a></li>
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
            <?php foreach($aCategories as $aCurCategory) { ?>
              <option value="<?php echo $aCurCategory['id']; ?>"<?php if($aCurCategory['id'] == $_GET['category']) { ?> selected="selected"<?php } ?>><?php echo $aCurCategory['name']; ?></option>
            <?php } ?>
          </select>
        <form>
      </div>
    </div><!-- /.filter-bar -->
    <?php } ?>

    <?php if(!empty($aPosts)) { ?>
      <div class="js-postList">
      <?php foreach($aPosts as $k=>$aPost) { ?>
        <div class="one-third post-panel" data-text-align="center">
          <div class="post-panel-inside">
            <a href="<?php echo $aPost['url']; ?>" title="Permalink for <?php echo $aPost['title']; ?>">
              <img src="/uploads/posts/<?php echo $aPost['listing_image']; ?>" alt="<?php echo $aPost['title']; ?>">
              <div class="post-title"><h5><?= $aPost['title'] ?></h5><span>Read now &raquo;</span></div>
            </a>
          </div> <!-- /.post-panel-inside -->
        </div> <!-- /.one-third.post-panel -->
      <?php } ?>
      </div>
    <?php } ?>
  </div><!-- /.blog-list -->

  <?php if($load_more) { ?>
  <div class="paging row js-loadMore">
    <div class="full">
      <a href="/ajax/blog/load_more/?category=<?php echo $_GET['category']; ?>&exclude=<?php echo $aLatestPost['id']; ?>&page=1" class="load-more button">Load More!</a>
    </div> <!-- /.full -->
  </div> <!-- /.paging.row -->
  <?php } ?>

  {footer}
  <script>
  $('.load-more').on('click', function() {
    var button = $(this);

    $.getJSON(button.attr('href'), function(data) {
      console.log(data);
      var posts = '';
      $.each(data.posts, function(key, post) {
        posts += '<div class="one-third post-panel" data-text-align="center">';
        posts += '<div class="post-panel-inside">';
        posts += '<a href="'+post.url+'" title="Permalink for '+post.title+'"><img src="/uploads/posts/'+post.listing_image+'" alt="'+post.title+'">';
        posts += '<div class="post-title"><h5>'+post.title+'</h5><span>Read now &raquo;</span></div></a>'
        posts += '</div> <!-- /.post-panel-inside --> </div> <!-- /.one-third.post-panel -->';
      });

      if(!data.load_more) {
        $('.js-loadMore').hide();
      }
      $('.js-postList').append(posts);
      button.attr('href', '/ajax/blog/load_more/?category=<?php echo $_GET['category']; ?>&exclude=<?php echo $aLatestPost['id']; ?>&page='+data.next_page);
    });

    return false;
  });

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
