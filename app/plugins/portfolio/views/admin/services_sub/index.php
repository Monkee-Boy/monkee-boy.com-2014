<?php $this->tplDisplay("inc_header.php", ['menu'=>'portfolio','sPageTitle'=>$aService['name']." &raquo; Services"]); ?>

  <h2>
    <a href="/admin/portfolio/services/"><?php echo $aService['name']; ?></a> &raquo; Manage Services
    <a href="/admin/portfolio/" title="Manage Portfolio" class="btn btn-primary pull-right" rel="tooltip" data-placement="bottom">Manage Portfolio</a>
    <a href="/admin/portfolio/services/<?php echo $aService['id']; ?>/sub/add/" title="Add Service" class="btn btn-primary pull-right" rel="tooltip" data-placement="bottom"><i class="icon-plus icon-white"></i> Add Service</a>
  </h2>

  <table  class="data-table table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th></th>
        <?php if($sSort == "manual"): ?>
          <th>Order</th>
        <?php endif; ?>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($aServicesSubs as $aServiceSub): ?>
        <tr>
          <td><?= $aServiceSub['name'] ?></td>
          <td><a href="/admin/portfolio/services/<?php echo $aService['id']; ?>/sub/<?php echo $aServiceSub['id']; ?>/item/">Manage Service Items</a></td>
          <?php if($sSort == "manual"): ?>
            <td class="small center">
              <span class="hidden"><?= $aServiceSub['sort_order'] ?></span>
              <?php if($aServiceSub['sort_order'] != $minSort): ?>
                <a href="/admin/portfolio/services/<?php echo $aService['id']; ?>/sub/sort/<?= $aServiceSub['id'] ?>/up/" title="Move Up One"><img src="/images/admin/icons/bullet_arrow_up.png" style="width:16px;height:16px;"></a>
              <?php else: ?>
                <img src="/images/blank.gif" style="width:16px;height:16px;">
              <?php endif; ?>
              <?php if($aServiceSub['sort_order'] != $maxSort && count($aService) > 1): ?>
                <a href="/admin/portfolio/services/<?php echo $aService['id']; ?>/sub/sort/<?= $aServiceSub['id'] ?>/down/" title="Move Down One"><img src="/images/admin/icons/bullet_arrow_down.png" style="width:16px;height:16px;"></a>
              <?php else: ?>
                <img src="/images/blank.gif" style="width:16px;height:16px;">
              <?php endif; ?>
            </td>
          <?php endif; ?>
          <td class="center">
            <a href="/admin/portfolio/services/<?php echo $aService['id']; ?>/sub/edit/<?= $aServiceSub['id'] ?>/" title="Edit Service" rel="tooltip"><i class="icon-pencil"></i></a>
            <a href="/admin/portfolio/services/<?php echo $aService['id']; ?>/sub/delete/<?= $aServiceSub['id'] ?>/" title="Delete Service" rel="tooltip" onclick="return confirm('Are you sure you would like to delete: <?= $aServiceSub['name'] ?>?');"><i class="icon-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

{footer}
<script>
$('.data-table').dataTable({
  /* DON'T CHANGE */
  "sDom": '<"dataTable-header"rf>t<"dataTable-footer"lip<"clear">',
  "sPaginationType": "full_numbers",
  "bLengthChange": false,
  /* CAN CHANGE */
  "bStateSave": false,
  "aaSorting": false, //which column to sort by (0-X)
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
