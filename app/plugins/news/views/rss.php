<?xml version="1.0"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title><?= getSetting("title") ?> News</title>
		<link>http://<?= $domain ?>/</link>
		<description></description>
		<language>en-us</language>
		<lastBuildDate><?= date('r') ?></lastBuildDate>
		<generator>http://<?= $domain ?>/</generator>
		<atom:link href="http://<?= $domain ?>/news/rss/" rel="self" type="application/rss+xml" />
		<?php foreach($aArticles as $aArticle): ?>
		<item>
			<title><?= $aArticle['title'] ?></title>
			<link>http://<?= $domain.$aArticle['url'] ?></link>
			<?php if(!empty($aArticle['excerpt'])): ?>
			<description><?= $aArticle['excerpt'] ?></description>
			<?php else: ?>
			<description><?= $aArticle['content'] ?></description>
			<?php endif; ?>
			<pubDate><?= date('D, d M Y H:i:s e', $aArticle['datetime_show']) ?></pubDate>
			<guid>http://<?= $domain.$aArticle['url'] ?></guid>
		</item>
		<?php endforeach; ?>
	</channel>
</rss>
