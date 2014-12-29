<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta name="description" content="<?php echo $this->getSetting("site-description"); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- May the source be with you! -->

  <title><?php if(!empty($page_title)){ echo $page_title.' | '; } echo $this->getSetting("site-title"); ?></title>

  <link rel="author" href="/humans.txt">
  <link rel="dns-prefetch" href="//ajax.googleapis.com">
  <link rel="sitemap" href="/sitemap.xml" type="application/xml" title="Sitemap">
  <link rel="alternate" type="application/rss+xml" title="RSS Feed" href="/feed/">

  <link rel="stylesheet" href="/css/style.min.css?v=2">

  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
  <script src="//use.typekit.net/shc0zig.js"></script>
  <script>try{Typekit.load();}catch(e){}</script>

  <script src="/js/modernizr.js"></script>
</head>
<body <?php if(!empty($menu)): ?> class="page-<?= $menu ?>"<?php endif; ?>>
  <!--[if lt IE 9]><p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p><![endif]-->

<div class="container" role="document">
	<?php if(!empty($menu) && ($menu === 'blog' || $menu === 'blog-post')) { include('inc_blog_navigation.php'); } else { include('inc_navigation.php'); } ?>
  <?php
  $aSubNav = array(
    'who' => array('why-monkee-boy','troop','news','join'),
    'what' => array('services','discover','create','evolve'),
    'work' => array('portfolio','testimonials','clients')
  );

  if(in_array($menu, $aSubNav['who'])) {
    $this->tplDisplay('inc_subnav.php', array('menu' => $menu, 'nav' => 'who'));
  } elseif(in_array($menu, $aSubNav['what'])) {
    $this->tplDisplay('inc_subnav.php', array('menu' => $menu, 'nav' => 'what'));
  } elseif(in_array($menu, $aSubNav['work'])) {
    $this->tplDisplay('inc_subnav.php', array('menu' => $menu, 'nav' => 'work'));
  }
  ?>
