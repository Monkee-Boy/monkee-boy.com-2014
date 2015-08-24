<?php
$optionsItems = array(
  array('name' => 'Lorem Ipsum Plan', 'url' => '/how-we-help/options/test-plan/', 'menu' => 'content-strategy'),
  array('name' => 'Dolor Amet Plan', 'url' => '/how-we-help/options/test-plan-two/', 'menu' => 'web-design-and-development')
);
?>

<ul class="dropdown-extended">
  <?php foreach($optionsItems as $item) { ?>
    <li><a href="<?= $item['url']; ?>"<?php if($menu === $item['menu']): ?> class="current"<?php endif; ?>><?= $item['name']; ?></a></li>
  <?php } ?>
</ul>

<?php if(isset($from) && $from === "subnav") { ?>
  <div class="select-box select-box-subnav">
    <select name="select-subnav" id="select-subnav">
      <option value="">View Plans</option>

      <?php foreach($optionsItems as $item) { ?>
        <option value="<?= $item['url']; ?>"<?php if($menu === $item['menu']): ?> selected<?php endif; ?>><?= $item['name']; ?></option>
      <?php } ?>
    </select>
  </div>
<?php } ?>
