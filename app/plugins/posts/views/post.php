<?php
$this->tplDisplay("inc_header.php", [
  'menu'=>'blog-post',
  'page_title'=>$aPost['title'],
  'seo_title'=>$aPost['seo_title'],
  'seo_description'=>$aPost['seo_description'],
  'seo_keywords'=>$aPost['seo_keywords'],

  'og_updated_time'=>date('Y-m-d\TH:i:sP', strtotime($aPost['updated_datetime'])),
  'og_image'=>'/uploads/posts/'.$aPost['featured_image'],
  'og_type'=>'article',
  'og_article_published'=>date('Y-m-d\TH:i:sP', strtotime($aPost['created_datetime'])),
  'og_article_modified'=>date('Y-m-d\TH:i:sP', strtotime($aPost['updated_datetime']))
]); ?>

  <div class="row">
    <div class="single-post single-column content-block">
      <?php echo $aPost['content']; ?>
    </div><!-- /.single-post -->
  </div> <!-- /.row -->

  <?php if(!empty($aPost['gallery']) && !empty($aPost['gallery']['photos'])) { ?>
  <div class="fullwidth-slider">
    <ul class="unstyled">
      <?php foreach($aPost['gallery']['photos'] as $key=>$gallery_photo) { ?>
      <li>
        <figure>
          <div class="slick-photo-wrapper">
            <img src="/uploads/galleries/<?php echo $aPost['gallery']['id']; ?>/<?php echo $gallery_photo['photo']; ?>" alt="<?php echo $gallery_photo['title']; ?>" id="post-photo-<?php echo $key; ?>">
          </div>
          <figcaption><?php echo $gallery_photo['description']; ?></figcaption>
        </figure>
      </li>
      <?php } ?>
    </ul>
  </div>
  <?php } ?>

  <div class="row">
    <div class="single-post single-column">
      <p>&nbsp;</p>
      <div class="share-section">
        <h4>Share this article</h4>
        <ul class="styleless">
          <li><a href="https://twitter.com/share?url=http://monkee-boy.com<?php echo $aPost['url']; ?>&text=<?php echo urlencode($aPost['title']); ?>&via=monkeeboy" class="twitter"><span class="social-twitter-count"></span></a></li>
          <li><a href="http://www.facebook.com/sharer.php?u=http://monkee-boy.com<?php echo $aPost['url']; ?>" class="facebook"><span class="social-facebook-count"></span></a></li>
          <li><a href="https://pinterest.com/pin/create/bookmarklet/?media=http://monkee-boy.com/uploads/posts/<?php echo $aPost['featured_image']; ?>&url=http://monkee-boy.com<?php echo $aPost['url']; ?>&description=<?php echo urlencode($aPost['title']); ?>" class="pinterest"><span class="social-pinterest-count"></span></a></li>
        </ul>
      </div>
    </div><!-- /.single-post -->
  </div>

  <div class="panel-wide blog-author" data-panel-color="green" data-panel-style="slash">
    <div class="row-flush">
      <div class="author-info">
        <img src="/uploads/troop/<?php echo $aPost['author']['photo']; ?>" alt="">
        <span class="name"><?php echo $aPost['author']['name']; ?></span>

        <?php if(!empty($aPost['author']['social_accounts'])) { ?>
        <ul class="social-links" role="menu">
          <?php foreach($aPost['author']['social_accounts'] as $network => $url) { ?>
            <?php if(!empty($url)) { ?><li><a href="<?php echo $url; ?>" class="<?php echo $network; ?>"><?php echo $network; ?></a></li><?php } ?>
          <?php } ?>
        </ul>
        <?php } ?>
      </div> <!-- /.author-info -->

      <?php if(!empty($aPost['author']['more_posts'])) { ?>
      <div class="author-articles">
        <h2><span class="subtitle">more from </span>the author</h2>
        <ul class="list-style-alt">
          <?php foreach($aPost['author']['more_posts'] as $author_post) { ?>
            <li><a href="<?php echo $author_post['url']; ?>"><?php echo $author_post['title']; ?></a></li>
          <?php } ?>
        </ul>
      </div> <!-- /.author-articles -->
      <?php } ?>
    </div> <!-- /.row-flush -->
  </div> <!-- /.panel-wide.blog-author -->

  <div class="row post-extras">
    <div class="single-post single-column">
      <?php if(!empty($aRelatedPosts)) { ?>
      <h3 data-text-align="center">You might also like:</h3>
      <div class="row-pop">
        <?php foreach($aRelatedPosts as $aRelatedPost) { ?>
        <div class="half post-panel" data-text-align="center">
          <div class="post-panel-inside">
            <a href="<?php echo $aRelatedPost['url']; ?>" title="Permalink for <?php echo $aRelatedPost['title']; ?>">
              <img src="/uploads/posts/<?php echo $aPost['listing_image']; ?>" alt="<?php echo $aRelatedPost['title']; ?>">
              <h4><?php echo $aRelatedPost['title']; ?><span>Read now &raquo;</span></h4>
            </a>
          </div> <!-- /.post-panel-inside -->
        </div> <!-- /.half.post-panel -->
        <?php } ?>
      </div> <!-- /.row-pop -->
      <?php } ?>

      <!-- Add Disqus Comments -->
      <div class="comment-section">
        <h3 data-text-align="center">Reader Comments</h3>

        <div id="disqus_thread"></div>
        <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'monkeeboyblog'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
          var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
          dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
          (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
      </div><!-- /.comment-section -->

    </div><!-- /.single-post -->
  </div>

  {footer}
  <script>var shareUrl = '<?php echo $aPost['url']; ?>';
  $.getJSON('http://count.donreach.com/?url=' + encodeURIComponent(shareUrl) + "&callback=?", function (data) {
   shares = data.shares;

   $('.social-twitter-count').html(shares.twitter);
   $('.social-facebook-count').html(shares.facebook);
   $('.social-pinterest-count').html(shares.pinterest);
  });
  </script>

  <script type="text/javascript">
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
