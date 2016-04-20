<?php
$whoItems = array(
  array('name' => 'Our Approach', 'url' => '/who/our-approach/', 'menu' => 'our-approach'),
  array('name' => 'Our Process', 'url' => '/who/our-process/', 'menu' => 'our-process'),
  array('name' => 'The Troop', 'url' => '/who/the-troop/', 'menu' => 'troop'),
  array('name' => 'Latest News', 'url' => '/who/latest-news/', 'menu' => 'news'),
  array('name' => 'Join The Troop', 'url' => '/who/join-the-troop/', 'menu' => 'join-the-troop')
);
?>

<ul>
  <?php foreach($whoItems as $item) { ?>
    <li><a href="<?= $item['url']; ?>"<?php if($menu === $item['menu']): ?> class="current"<?php endif; ?>><?= $item['name']; ?></a></li>
  <?php } ?>
</ul>

<?php if(isset($from) && $from === "subnav") { ?>
  <div class="select-box select-box-subnav">
    <select name="select-subnav" id="select-subnav">
      <option value="">View Subpages</option>

      <?php foreach($whoItems as $item) { ?>
        <option value="<?= $item['url']; ?>"<?php if($menu === $item['menu']): ?> selected<?php endif; ?>><?= $item['name']; ?></option>
      <?php } ?>
    </select>
  </div>
<?php } ?>
