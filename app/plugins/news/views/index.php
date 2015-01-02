<?php $this->tplDisplay("inc_header.php", ['menu'=>'news','page_title'=>'News']); ?>

{head}
<link rel="alternate" type="application/rss+xml" title="All Articles RSS" href="/news/rss/">
<?php if(isset($_GET['category']) && !empty($_GET['category'])): ?>
  <link rel="alternate" type="application/rss+xml" title="Articles in <?= $aCategory['name'] ?> RSS" href="/news/rss/?category=<?= $_GET['category'] ?>">
<?php endif; ?>
<meta property="og:site_name" content="<?= $this->getSetting("site-title") ?>">
{/head}

<div id="fb-root"></div>
<script>
  var news_current_page = 1;
  var news_total_pages = <?= $aPaging['total'] ?>;

  window.fbAsyncInit = function() {
    FB.init({appId: '127471297263601', status: true, cookie: true,
             xfbml: true});
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>

  <div class="row">
    <div class="page-title">
      <h1>Latest News</h1>
      <p class="subtitle">we do stuff, in our office &amp; around town</p>
    </div>
  </div>

  <?php if(!empty($aTopArticle)): ?>
  <div class="row">
    <div class="full news-item top-article">
      <div class="date"><?= date("m.d", $aTopArticle['publish_on']) ?><span><?= date("Y", $aTopArticle['publish_on']) ?></span></div>
      <h3><a href="<?= $aTopArticle['url'] ?>" title="<?= $aTopArticle['title'] ?>"><?= $aTopArticle['title'] ?> &raquo;</a></h3>
    </div>
  </div>
  <?php endif; ?>


  <?php if(count($aCategories) > 1): ?>
  <div class="row">
    <div class="full category-filter">
      <form name="category" method="get" action="/latest-news/" class="sortCat">
        <label>Show Monkee-Boy News By:</label>
        <div class="select-box">
          <select name="category">
            <option value="">Select a Filter</option>
            <?php foreach($aCategories as $aCategory): ?>
              <option value="<?= $aCategory['id'] ?>"<?php if($aCategory['id'] == $_GET['category']){ echo ' selected="selected"'; } ?>><?= $aCategory['name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        {footer}
        <script type="text/javascript">
        $(function(){
          $('select[name=category]').change(function(){
            $('form[name=category]').submit();
          });
        });
        </script>
        {/footer}
      </form>
    </div>
  </div>
  <?php endif; ?>

  <?php if(!empty($aArticles)): ?>
    <?php foreach($aArticles as $aArticle): ?>
    <div class="row">
      <div class="full news-item">
        <div class="date"><?= date("m.d", $aArticle['publish_on']) ?><span><?= date("Y", $aArticle['publish_on']) ?></span></div>
        <h3><a href="<?= $aArticle['url'] ?>" title="<?= $aArticle['title'] ?>"><?= $aArticle['title'] ?> &raquo;</a></h3>
      </div>
      <hr>
    </div>
    <?php endforeach; ?>
    <div class="row">
      <div class="full">
        <a href="#" class="news-load-more">Load More!</a>
      </div>
    </div>
  <?php endif; ?>

	<!-- <?php if($aPaging['next']['use'] == true): ?>
		<p class="right paging"><a href="<?= preserve_query('page', $aPaging['next']['page']) ?>">Next &raquo;</a></p>
	<?php endif; ?>
	<?php if($aPaging['back']['use'] == true): ?>
		<p class="left paging"><a href="<?= preserve_query('page', $aPaging['back']['page']) ?>">&laquo; Back</a></p>
	<?php endif; ?>
	<p style="text-align: center;">Page <?= $aPaging['current'] ?> of <?= $aPaging['total'] ?></p>
	<div class="clear">&nbsp;</div> -->

	<!-- <div style="text-align:center;margin-top:10px">
		<a href="/news/rss/<?php if(!empty($_GET['category'])){ echo '?category='.$_GET['category']; } ?>">
			<img src="/images/admin/icons/feed.png"> RSS Feed
		</a>
	</div> -->

<?php $this->tplDisplay("inc_footer.php"); ?>
