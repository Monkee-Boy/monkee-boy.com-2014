<?php $this->tplDisplay("inc_header.php", ['menu'=>'portfolio','sPageTitle'=>"Portfolio"]); ?>

  <h2>
    Manage Portfolio
    <a href="/admin/portfolio/services/" title="Manage Services" class="btn btn-primary pull-right" rel="tooltip" data-placement="bottom">Manage Services</a>
    <a href="/admin/portfolio/add/" title="Add Client" class="btn btn-primary pull-right" rel="tooltip" data-placement="bottom"><i class="icon-plus icon-white"></i> Add Client</a>
  </h2>

  <table  class="data-table table table-striped">
    <thead>
      <tr>
        <th class="empty itemStatus">&nbsp;</th>
        <th>Name</th>
        <th>Featured</th>
        <th>App</th>
        <?php if($sSort == "manual"): ?>
          <th>Order</th>
        <?php endif; ?>
        <th>Slides</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($aClients as $aClient): ?>
        <tr>
          <td>
            <?php if($aClient['active'] == 1): ?>
              <img src="/images/icons/bullet_green.png" alt="active">
            <?php else: ?>
              <img src="/images/icons/bullet_red.png" alt="inactive">
            <?php endif; ?>
          </td>
          <td><?= $aClient['name'] ?></td>
          <td>
            <?php if($aClient['featured'] == 1): ?>
              Yes
            <?php else: ?>
              No
            <?php endif; ?>
          </td>
          <td>
            <?php if($aClient['app'] == 1): ?>
              Yes
            <?php else: ?>
              No
            <?php endif; ?>
          </td>
          <?php if($sSort == "manual"): ?>
            <td class="small center">
              <span class="hidden"><?= $aClient['sort_order'] ?></span>
              <?php if($aClient['sort_order'] != $minSort): ?>
                <a href="/admin/portfolio/sort/<?= $aClient['id'] ?>/up/" title="Move Up One"><img src="/images/admin/icons/bullet_arrow_up.png" style="width:16px;height:16px;"></a>
              <?php else: ?>
                <img src="/images/blank.gif" style="width:16px;height:16px;">
              <?php endif; ?>
              <?php if($aClient['sort_order'] != $maxSort && count($aClient) > 1): ?>
                <a href="/admin/portfolio/sort/<?= $aClient['id'] ?>/down/" title="Move Down One"><img src="/images/admin/icons/bullet_arrow_down.png" style="width:16px;height:16px;"></a>
              <?php else: ?>
                <img src="/images/blank.gif" style="width:16px;height:16px;">
              <?php endif; ?>
            </td>
          <?php endif; ?>
          <td class="center"><?= count($aClient['slides']) ?></td>
          <td class="center">
            <a href="/admin/portfolio/<?= $aClient['id'] ?>/slides/" title="Manage Slides" rel="tooltip">Manage Slides</a>
          </td>
          <td class="center">
            <a href="/admin/portfolio/edit/<?= $aClient['id'] ?>/" title="Edit Client" rel="tooltip"><i class="icon-pencil"></i></a>
            <a href="/admin/portfolio/delete/<?= $aClient['id'] ?>/" title="Delete Client" rel="tooltip" onclick="return confirm('Are you sure you would like to delete: <?= $aClient['name'] ?>?');"><i class="icon-trash"></i></a>
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
  "bStateSave": true,
  "aaSorting": [[ 0, "asc" ]], //which column to sort by (0-X)
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
