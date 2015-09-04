<?php
$howItems = array(
  array('name' => 'Web Design and Development', 'url' => '/how-we-help/web-design-and-development/', 'menu' => 'web-design-and-development'),
  array('name' => 'Content Strategy', 'url' => '/how-we-help/content-strategy/', 'menu' => 'content-strategy'),
  array('name' => 'Analytics', 'url' => '/how-we-help/analytics/', 'menu' => 'analytics'),
  array('name' => 'Website Maintenance', 'url' => '/how-we-help/website-maintenance/', 'menu' => 'website-maintenance'),
  array('name' => 'Content Marketing', 'url' => '/how-we-help/content-marketing/', 'menu' => 'content-marketing'),
  array('name' => 'Social Media', 'url' => '/how-we-help/social-media/', 'menu' => 'social-media'),
  array('name' => 'SEO', 'url' => '/how-we-help/seo/', 'menu' => 'seo'),
  array('name' => 'Pay-Per-Click', 'url' => '/how-we-help/pay-per-click/', 'menu' => 'pay-per-click'),
);
?>

<ul class="dropdown-extended">
  <?php foreach($howItems as $item) { ?>
    <li><a href="<?= $item['url']; ?>"<?php if($menu === $item['menu']): ?> class="current"<?php endif; ?>><?= $item['name']; ?></a></li>
  <?php } ?>
</ul>

<?php if(isset($from) && $from === "subnav") { ?>
  <div class="select-box select-box-subnav">
    <select name="select-subnav" id="select-subnav">
      <option value="">View Subpages</option>

      <?php foreach($howItems as $item) { ?>
        <option value="<?= $item['url']; ?>"<?php if($menu === $item['menu']): ?> selected<?php endif; ?>><?= $item['name']; ?></option>
      <?php } ?>
    </select>
  </div>
<?php } ?>
