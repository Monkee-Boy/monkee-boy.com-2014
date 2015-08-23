<?php
$contactItems = array(
  array('name' => 'Request a Quote', 'url' => '/contact/request-a-quote/', 'menu' => 'request-a-quote'),
  array('name' => 'Find Us', 'url' => '/contact/', 'menu' => 'contact')
);
?>

<ul>
  <?php foreach($contactItems as $item) { ?>
    <li><a href="<?= $item['url']; ?>"<?php if($menu === $item['menu']): ?> class="current"<?php endif; ?>><?= $item['name']; ?></a></li>
  <?php } ?>
</ul>

<?php if(isset($from) && $from === "subnav") { ?>
  <div class="select-box select-box-subnav">
    <select name="select-subnav" id="select-subnav">
      <option value="">View Subpages</option>

      <?php foreach($contactItems as $item) { ?>
        <option value="<?= $item['url']; ?>"<?php if($menu === $item['menu']): ?> selected<?php endif; ?>><?= $item['name']; ?></option>
      <?php } ?>
    </select>
  </div>
<?php } ?>
