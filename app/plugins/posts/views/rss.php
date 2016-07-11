<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0" xmlns:media="http://search.yahoo.com/mrss/">
<channel>
  <title><?= strip_tags($this->getSetting('site-title')); ?> Posts</title>
  <description></description>
  <link>http://<?= $domain; ?>/</link>
  <generator>Kaizen CMS</generator>
  <lastBuildDate><?= date('r', $aPosts[0]['publish_on']); ?></lastBuildDate>
  <atom:link href="http://<?= $domain; ?>/blog/rss/" rel="self" type="application/rss+xml"/>
  <ttl>60</ttl>
  <?php foreach($aPosts as $k=>$aPost) { ?>
  <item>
    <title><?= $aPost['title']; ?></title>
    <description><![CDATA[ <?= $aPost['excerpt']; ?> ]]></description>
    <link>http://<?= $domain; ?><?= $aPost['url']; ?></link>
    <guid isPermaLink="false">http://<?= $domain; ?><?= $aPost['url']; ?></guid>
    <pubDate><?= date('r', $aPost['publish_on']); ?></pubDate>
  </item>
  <?php } ?>
</channel>
</rss>
