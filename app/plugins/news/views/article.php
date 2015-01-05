<?php
$this->tplDisplay("inc_header.php", [
  'menu'=>'news',
  'page_title'=>$aArticle['title'],
  'seo_title'=>$aArticle['seo_title'],
  'seo_description'=>$aArticle['seo_description'],
  'seo_keywords'=>$aArticle['seo_keywords'],

  'og_updated_time'=>date('Y-m-d\TH:i:sP', strtotime($aArticle['updated_datetime'])),
  'og_type'=>'article',
  'og_article_published'=>date('Y-m-d\TH:i:sP', strtotime($aArticle['created_datetime'])),
  'og_article_modified'=>date('Y-m-d\TH:i:sP', strtotime($aArticle['updated_datetime']))
]); ?>

{head}
<meta property="og:title" content="<?= $aArticle['title'] ?>">
<meta property="og:site_name" content="<?= $this->getSetting("site-title") ?>">
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

  <div class="row">
    <div class="page-title">
      <h1><?= $aArticle['title'] ?></h1>
    </div>
  </div>

  <div class="row">
    <div class="single-column news-article">
      <div class="date"><?= date("m.d.Y", $aArticle['publish_on']) ?></div>

      <div class="content"><?= $aArticle['content'] ?></div>
    </div>
  </div>

<?php $this->tplDisplay("inc_footer.php"); ?>
