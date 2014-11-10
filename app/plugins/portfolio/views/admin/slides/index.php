<?php $this->tplDisplay("inc_header.php", ['menu'=>'portfolio','sPageTitle'=>"Portfolio Slides"]); ?>

  <h2>
    Manage Portfolio Slides
    <a href="/admin/portfolio/" title="Manage Portfolio" class="btn btn-primary pull-right" rel="tooltip" data-placement="bottom">Manage Portfolio</a>
    <a href="/admin/portfolio/<?= $aClient['id'] ?>/slides/add/" title="Add Slide" class="btn btn-primary pull-right" rel="tooltip" data-placement="bottom"><i class="icon-plus icon-white"></i> Add Slide</a>
  </h2>

  <table  class="data-table table table-striped">
    <thead>
      <tr>
        <th></th>
        <?php if($sSort == "manual"): ?>
          <th>Order</th>
        <?php endif; ?>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($aSlides as $aSlide): ?>
        <tr>
          <td><img src="<?php echo $aSlide['listing_image_url']; ?>" alt="Listing Image" style="max-width: 60px;"></td>
          <?php if($sSort == "manual"): ?>
            <td class="small center">
              <span class="hidden"><?= $aSlide['sort_order'] ?></span>
              <?php if($aSlide['sort_order'] != $minSort): ?>
                <a href="/admin/portfolio/sort/<?= $aSlide['id'] ?>/up/" title="Move Up One"><img src="/images/admin/icons/bullet_arrow_up.png" style="width:16px;height:16px;"></a>
              <?php else: ?>
                <img src="/images/blank.gif" style="width:16px;height:16px;">
              <?php endif; ?>
              <?php if($aSlide['sort_order'] != $maxSort && count($aSlides) > 1): ?>
                <a href="/admin/portfolio/sort/<?= $aSlide['id'] ?>/down/" title="Move Down One"><img src="/images/admin/icons/bullet_arrow_down.png" style="width:16px;height:16px;"></a>
              <?php else: ?>
                <img src="/images/blank.gif" style="width:16px;height:16px;">
              <?php endif; ?>
            </td>
          <?php endif; ?>
          <td class="center">
            <a href="/admin/portfolio/<?= $aClient['id'] ?>/slides/edit/<?= $aSlide['id'] ?>/" title="Edit Slide" rel="tooltip"><i class="icon-pencil"></i></a>
            <a href="/admin/portfolio/<?= $aClient['id'] ?>/slides/delete/<?= $aSlide['id'] ?>/" title="Delete Slide" rel="tooltip" onclick="return confirm('Are you sure you would like to delete this slide?');"><i class="icon-trash"></i></a>
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
