<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php if(!empty($seo_description)): ?>
  <meta name="description" content="<?= $seo_description ?>">
  <?php else: ?>
  <meta name="description" content="<?php echo strip_tags($this->getSetting("site-description")); ?>">
  <?php endif; ?>
  <?php if(!empty($seo_description)): ?>
  <meta name="keywords" content="<?= $seo_keywords ?>">
  <?php endif; ?>

  <!-- Open Graph -->
  <meta property="og:title" content="<?php if(!empty($seo_title)){ echo strip_tags($seo_title); } elseif(!empty($page_title)) { echo strip_tags($page_title); } else { echo strip_tags($this->getSetting("site-title")); } ?>">
  <meta property="og:description" content="<?php if(!empty($seo_description)){ echo strip_tags($seo_description); } else { echo strip_tags($this->getSetting("site-description")); } ?>">
  <meta property="og:image" content="http://<?php echo $_SERVER['SERVER_NAME']; if(!empty($og_image)){ echo $og_image; } else { echo '/images/mboy-opengraph.png'; } ?>">
  <?php if(!empty($og_updated_time)): ?><meta property="og:updated_time" content="<?= $og_updated_time ?>"><?php endif; ?>
  <meta property="og:type" content="<?php if(!empty($og_type)){ echo $og_type; } else { echo 'website'; } ?>">
  <?php if($og_type === 'article'): ?>
    <?php if(!empty($og_article_published)): ?><meta property="article:published_time" content="<?= $og_article_published ?>"><?php endif; ?>
    <?php if(!empty($og_article_modified)): ?><meta property="article:modified_time" content="<?= $og_article_modified ?>"><?php endif; ?>
  <?php endif; ?>
  <meta property="og:site_name" content="Monkee-Boy.com">

	<!-- May the source be with you! -->

  <title><?php if(!empty($seo_title)){ echo $seo_title; }else{ if(!empty($page_title)){ echo $page_title.' | '; } echo $this->getSetting("site-title"); } ?></title>

  <link rel="author" href="/humans.txt">
  <link rel="dns-prefetch" href="//ajax.googleapis.com">
  <link rel="sitemap" href="/sitemap.xml" type="application/xml" title="Sitemap">

  <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
  <link rel="icon" type="image/png" href="/favicon-192x192.png" sizes="192x192">
  <link rel="icon" type="image/png" href="/favicon-160x160.png" sizes="160x160">
  <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
  <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
  <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
  <meta name="msapplication-TileColor" content="#acca41">
  <meta name="msapplication-TileImage" content="/mstile-144x144.png">

  <link rel="stylesheet" href="/css/app.min.css?v=2">

  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
  <script src="//use.typekit.net/shc0zig.js"></script>
  <script>try{Typekit.load();}catch(e){}</script>

  <script src="/js/modernizr.js"></script>
</head>
<body <?php if(!empty($menu)): ?> class="page-<?= $menu ?>"<?php endif; ?>>
  <!--[if lt IE 9]><p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p><![endif]-->

<div class="container" role="document">
	<?php
  if(!empty($menu) && ($menu === 'blog' || $menu === 'blog-post')) {
    include('inc_blog_navigation.php');
  } else {
    $aSubNav = array(
      'who' => array('why-monkee-boy','troop','news','join-the-troop'),
      'what' => array('services','discover','create','evolve'),
      'work' => array('portfolio','testimonials','clients'),
      'contact' => array('contact','request-a-quote')
    );

    if(in_array($menu, $aSubNav['who'])) {
      $this->tplDisplay('inc_navigation.php', array('current' => 'who'));
      $this->tplDisplay('inc_subnav.php', array('menu' => $menu, 'nav' => 'who'));
    } elseif(in_array($menu, $aSubNav['what'])) {
      $this->tplDisplay('inc_navigation.php', array('current' => 'what'));
      $this->tplDisplay('inc_subnav.php', array('menu' => $menu, 'nav' => 'what'));
    } elseif(in_array($menu, $aSubNav['work'])) {
      $this->tplDisplay('inc_navigation.php', array('current' => 'work'));
      $this->tplDisplay('inc_subnav.php', array('menu' => $menu, 'nav' => 'work'));
    } elseif(in_array($menu, $aSubNav['contact'])) {
      $this->tplDisplay('inc_navigation.php', array('current' => 'contact'));
      $this->tplDisplay('inc_subnav.php', array('menu' => $menu, 'nav' => 'contact'));
    } else {
      $this->tplDisplay('inc_navigation.php');
    }
  }
  ?>
