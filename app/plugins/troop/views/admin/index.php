<?php $this->tplDisplay("inc_header.php", ['menu'=>'troop','sPageTitle'=>"Troop"]); ?>

  <h2>Manage Troop <a href="/admin/troop/add/" title="Add Employee" class="btn btn-primary pull-right" rel="tooltip" data-placement="bottom"><i class="icon-plus icon-white"></i> Add Employee</a></h2>

  <table  class="data-table table table-striped">
    <thead>
      <tr>
        <th class="empty itemStatus">&nbsp;</th>
        <th>Name</th>
        <?php if($sSort == "manual"): ?>
          <th>Order</th>
        <?php endif; ?>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($aTroop as $aEmployee): ?>
        <tr>
          <td>
            <?php if($aEmployee['active'] == 1): ?>
              <img src="/images/icons/bullet_green.png" alt="active">
            <?php else: ?>
              <img src="/images/icons/bullet_red.png" alt="inactive">
            <?php endif; ?>
          </td>
          <td><?= $aEmployee['name'] ?></td>
          <?php if($sSort == "manual"): ?>
            <td class="small center">
              <span class="hidden"><?= $aEmployee['sort_order'] ?></span>
              <?php if($aEmployee['sort_order'] != $minSort): ?>
                <a href="/admin/troop/sort/<?= $aEmployee['id'] ?>/up/" title="Move Up One"><img src="/images/icons/bullet_arrow_up.png" style="width:16px;height:16px;"></a>
              <?php else: ?>
                <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" style="width:16px;height:16px;">
              <?php endif; ?>
              <?php if($aEmployee['sort_order'] != $maxSort && count($aEmployee) > 1): ?>
                <a href="/admin/troop/sort/<?= $aEmployee['id'] ?>/down/" title="Move Down One"><img src="/images/icons/bullet_arrow_down.png" style="width:16px;height:16px;"></a>
              <?php else: ?>
                <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" style="width:16px;height:16px;">
              <?php endif; ?>
            </td>
          <?php endif; ?>
          <td class="center">
            <a href="/admin/troop/edit/<?= $aEmployee['id'] ?>/" title="Edit Employee" rel="tooltip"><i class="icon-pencil"></i></a>
            <a href="/admin/troop/delete/<?= $aEmployee['id'] ?>/" title="Delete Employee" rel="tooltip" onclick="return confirm('Are you sure you would like to delete: <?= $aEmployee['name'] ?>?');"><i class="icon-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <ul class="data-table-legend">
    <li class="bullet-green">Active</li>
    <li class="bullet-red">Inactive</li>
  </ul>

{footer}
<script>
$('.data-table').dataTable({
  /* DON'T CHANGE */
  "sDom": '<"dataTable-header"rf>t<"dataTable-footer"lip<"clear">',
  "sPaginationType": "full_numbers",
  "bLengthChange": false,
  /* CAN CHANGE */
  "bStateSave": false,
  "aaSorting": [[ 2, "asc" ]], //which column to sort by (0-X)
  "aoColumns": [
    null,
    null,
    { "sType": "num-html" },
    null
  ],
  "iDisplayLength": 10 //how many items to display per page
});
$('.dataTable-header').prepend('<?php
foreach($aAdminFullMenu as $k=>$aMenu) {
  if($k == $menu) {
    if(count($aMenu['menu']) > 1) {
      echo '<ul class="nav nav-pills">';
      foreach($aMenu['menu'] as $aItem) {
        echo '<li';
        if($subMenu == $aItem['text']) {
          echo ' class="active"';
        }
        echo '><a href="'.$aItem['link'].' title="'.$aItem['text'].'">'.$aItem['text'].'</a></li>';
      }
      echo '</ul>';
    }
  }
}
?>');
</script>
{/footer}

<?php $this->tplDisplay("inc_footer.php"); ?>
