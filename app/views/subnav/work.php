<?php
$workItems = array(
  array('name' => 'Portfolio', 'url' => '/the-work/', 'menu' => 'portfolio'),
  array('name' => 'Testimonials', 'url' => '/the-work/testimonials/', 'menu' => 'testimonials'),
  array('name' => 'Clients', 'url' => '/the-work/client-list/', 'menu' => 'clients')
);
?>

<ul>
  <?php foreach($workItems as $item) { ?>
    <li><a href="<?= $item['url']; ?>"<?php if($menu === $item['menu']): ?> class="current"<?php endif; ?>><?= $item['name']; ?></a></li>
  <?php } ?>
</ul>

<?php if(isset($from) && $from === "subnav") { ?>
  <div class="select-box select-box-subnav">
    <select name="select-subnav" id="select-subnav">
      <option value="">View Subpages</option>

      <?php foreach($workItems as $item) { ?>
        <option value="<?= $item['url']; ?>"<?php if($menu === $item['menu']): ?> selected<?php endif; ?>><?= $item['name']; ?></option>
      <?php } ?>
    </select>
  </div>
<?php } ?>
