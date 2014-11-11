<?php $this->tplDisplay("inc_header.php", ['menu'=>'news','page_title'=>'News']); ?>

{head}
<link rel="alternate" type="application/rss+xml" title="All Articles RSS" href="/news/rss/">
<?php if(!empty($_GET['category'])): ?>
  <link rel="alternate" type="application/rss+xml" title="Articles in <?= $aCategory['name'] ?> RSS" href="/news/rss/?category=<?= $_GET['category'] ?>">
<?php endif; ?>
<meta property="og:site_name" content="<?= getSetting("site-title") ?>">
{/head}

<div id="fb-root"></div>
<script>
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

	<?php if(count($aCategories) > 1): ?>
	<form name="category" method="get" action="/news/" class="sortCat">
		Category:
		<select name="category">
			<option value="">- All Categories -</option>
			<?php foreach($aCategories as $aCategory): ?>
				<option value="<?= $aCategory['id'] ?>"<?php if($aCategory['id'] == $_GET['category']){ echo ' selected="selected"'; } ?>><?= $aCategory['name'] ?></option>
			<?php endforeach; ?>
		</select>
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
  <?php endif; ?>

	<h2>Latest News<?if(!empty($aCategory)){ echo ' in '.$aCategory['name']; } ?></h2>
	<div class="clear">&nbsp;</div>

	<?php if(!empty($aArticles)): ?>
    <?php foreach($aArticles as $aArticle): ?>
  		<article>
  			<h3><a href="<?= $aArticle['url'] ?>" title="<?= $aArticle['title'] ?>"><?= $aArticle['title'] ?></a></h3>
  			<small class="timeCat">
  				<time><?= formatDateTime($aArticle['publish_on']) ?></time>
  				<?php if(!empty($aArticle['categories'])): ?>
  					| Categories:
  					<?php foreach($aArticle['categories'] as $key=>$aCategory): ?>
  						<a href="/news/?category={$aCategory.id}" title="Articles in <?= $aCategory['name'] ?>"><?= $aCategory['name'] ?></a><?php if($key+1 == count($aArticle['categories'])){ echo ","; } ?>
  					<?php endforeach; ?>
  				<?php endif; ?>
  			</small>

  			<p><?= $aArticle['excerpt'] ?>&hellip; <a href="<?= $aArticle['url'] ?>" title="<?= $aArticle['title'] ?>">More Info&raquo;</a></p>
  		</article>
    <?php endforeach; ?>
	<?php else: ?>
		<p>There are currently no posts.</p>
	<?php endif; ?>

	<?php if($aPaging['next']['use'] == true): ?>
		<p class="right paging"><a href="<?= preserve_query('page', $aPaging['next']['page']) ?>">Next &raquo;</a></p>
	<?php endif; ?>
	<?php if($aPaging['back']['use'] == true): ?>
		<p class="left paging"><a href="<?= preserve_query('page', $aPaging['back']['page']) ?>">&laquo; Back</a></p>
	<?php endif; ?>
	<p style="text-align: center;">Page <?= $aPaging['current'] ?> of <?= $aPaging['total'] ?></p>
	<div class="clear">&nbsp;</div>

	<div style="text-align:center;margin-top:10px">
		<a href="/news/rss/<?php if(!empty($_GET['category'])){ echo '?category='.$_GET['category']; } ?>">
			<img src="/images/admin/icons/feed.png"> RSS Feed
		</a>
	</div>

<?php $this->tplDisplay("inc_footer.php"); ?>
