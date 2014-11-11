<?php $this->tplDisplay("inc_header.php", ['menu'=>'news','page_title'=>$aArticle['title']]); ?>
{head}
<meta property="og:title" content="{$aArticle.title}">
<meta property="og:site_name" content="{getSetting tag="site-title"}">
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

	<h2><?= $aArticle['title'] ?></h2>
	<small class="timeCat">
		<time><?= formatDateTime($aArticle['publish_on']) ?></time>
		<?php if(!empty($aArticle['categories'])): ?>
			| Categories:
			<?php foreach($aArticle['categories'] as $key => $aCategory): ?>
				<a href="/news/?category=<?= $aCategory['id'] ?>" title="Posts in <?= $aCategory['name'] ?>"><?= $aCategory['name'] ?></a><?php if($key+1 != count($aArticle['categories'])){ echo ","; } ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</small>

	{$aArticle.content}

<?php $this->tplDisplay("inc_footer.php"); ?>
