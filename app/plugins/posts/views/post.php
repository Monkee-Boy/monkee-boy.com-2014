<?php $this->tplDisplay("inc_header.php", ['menu'=>'blog-post']); ?>

  <div class="row">
    <div class="single-post single-column">
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
    <div class="single-post">
      <p>&nbsp;</p>
      <div class="share-section">
        <h4>Share this article</h4> <!-- TODO: Add social share counts. -->
        <ul class="styleless">
          <li><a href="https://twitter.com/share?url=http://monkee-boy.com<?php echo $aPost['url']; ?>&text=<?php echo urlencode($aPost['title']); ?>&via=monkeeboy" class="twitter"><span>6</span></a></li>
          <li><a href="http://www.facebook.com/sharer.php?u=http://monkee-boy.com<?php echo $aPost['url']; ?>" class="facebook"><span>12</span></a></li>
          <li><a href="https://pinterest.com/pin/create/bookmarklet/?media=http://monkee-boy.com/uploads/posts/<?php echo $aPost['featured_image']; ?>&url=http://monkee-boy.com<?php echo $aPost['url']; ?>&description=<?php echo urlencode($aPost['title']); ?>" class="pinterest"><span>105</span></a></li>
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
    <div class="single-post">
      <h3 data-text-align="center">You might also like:</h3> <!-- TODO: Add related posts. -->
      <div class="row-pop">
        <div class="half post-panel" data-text-align="center">
          <div class="post-panel-inside">
            <a href="" title=""><img src="/assets/blog-post.jpg" alt=""></a>
            <h4><a href="" title="">Freebie Friday: 25 Colorful Polygon Backgrounds</a></h4>
          </div>
        </div>
        <div class="half post-panel" data-text-align="center">
          <div class="post-panel-inside">
            <a href="" title=""><img src="/assets/blog-post.jpg" alt=""></a>
            <h4><a href="" title="">Freebie Friday: 25 Colorful Polygon Backgrounds</a></h4>
          </div>
        </div>
      </div>

      <!-- Add Disqus Comments -->
      <div class="comment-section">
        <h3 data-text-align="center">Reader Comments</h3>
        <ul class="comments">
          <li>
            <span class="pic" style="background-image:url(http://cdn.morguefile.com/imageData/public/files/t/typexnick/preview/fldr_2012_03_03/file5751330778129.jpg)"></span>
            <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia a odio con nec elit. Cras mattis consectetur purus sit amet fermentum.</p>
            <ul class="menu-lite">
              <li>Longeruser middlename fullname</li>
              <li>June 20th, 2014</li>
              <li><a href="#">reply</a></li>
            </ul>

            <ul class="nested-replies">
              <li>
                <span class="pic" style="background-image:url(http://cdn.morguefile.com/imageData/public/files/e/ecerroni/preview/fldr_2008_11_13/file0002019118431.jpg)"></span>
                <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia a odio con nec elit. Cras mattis consectetur purus sit amet fermentum.</p>
                <ul class="menu-lite">
                  <li>User Fullname</li>
                  <li>June 27th, 2014</li>
                  <li><a href="#">reply</a></li>
                </ul>
              </li>
            </ul><!-- /.nested-replies -->

          </li>
          <li>
            <span class="pic" style="background-image:url(http://cdn.morguefile.com/imageData/public/files/r/ronnieb/preview/fldr_2005_11_02/file000410741279.jpg)"></span>
            <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia a odio con nec elit. Cras mattis consectetur purus sit amet fermentum. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. </p>
            <ul class="menu-lite">
              <li>User Fullname</li>
              <li>July 1st, 2014</li>
              <li><a href="#">reply</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.comment-section -->

    </div><!-- /.single-post -->
  </div>

<?php $this->tplDisplay("inc_footer.php"); ?>
