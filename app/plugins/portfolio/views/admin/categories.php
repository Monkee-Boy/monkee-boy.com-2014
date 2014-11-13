<?php $this->tplDisplay("inc_header.php", ['menu'=>'portfolio','sPageTitle'=>"Portfolio &raquo; Categories"]); ?>

  <h1>Categories <a class="btn btn-primary pull-right" href="/admin/portfolio/" title="Manage Portfolio" rel="tooltip" data-placement="bottom">Manage Portfolio</a></h1>
  <?php $this->tplDisplay('inc_alerts.php'); ?>

    <div class="row-fluid">
      <div class="span8">
        <table class="data-table table table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <?php if($sSort == "manual"){ echo '<th>Order</th>'; } ?>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($aCategories as $aCategory): ?>
              <tr>
                <td><?= $aCategory['name'] ?></td>
                <?php if($sSort == "manual"): ?>
                  <td class="small center">
                    <span class="hidden"><?= $aCategory['sort_order'] ?></span>
                    <?php if($aCategory['sort_order'] != $minSort): ?>
                      <a href="/admin/portfolio/categories/sort/<?= $aCategory['id'] ?>/up/" title="Move Up One"><img src="/images/icons/bullet_arrow_up.png" style="width:16px;height:16px;"></a>
                    <?php else: ?>
                      <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" style="width:16px;height:16px;">
                    <?php endif; ?>
                    <?php if($aCategory['sort_order'] != $maxSort && count($aCategories) > 1): ?>
                      <a href="/admin/portfolio/categories/sort/<?= $aCategory['id'] ?>/down/" title="Move Down One"><img src="/images/icons/bullet_arrow_down.png" style="width:16px;height:16px;"></a>
                    <?php else: ?>
                      <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" style="width:16px;height:16px;">
                    <?php endif; ?>
                  </td>
                <?php endif; ?>
                <td class="center">
                  <a href="/admin/portfolio/categories/?category=<?= $aCategory['id'] ?>" title="Edit Category"><i class="icon-pencil"></i></a>
                  <a href="/admin/portfolio/categories/delete/<?= $aCategory['id'] ?>/"
                   onclick="return confirm('Are you sure you would like to delete: <?= $aCategory['name'] ?>?');" title="Delete Category"><i class="icon-trash"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="span4 aside">
        <?php if(!empty($aCategoryEdit)): ?>
          <div class="accordion-group">
            <div class="accordion-heading">
              <span class="accordion-toggle">Edit Category</span>
            </div>
            <div class="accordion-body in collapse">
              <div class="accordion-inner">
                <form id="edit-form" method="post" action="/admin/portfolio/categories/edit/s/">
                  <div class="control-group">
                    <label class="control-label" for="form-name">Name</label>
                    <div class="controls">
                      <input type="text" name="name" id="form-name" value="<?= $aCategoryEdit['name'] ?>" class="span12 validate[required]"><br />
                    </div>
                  </div>

                  <!-- <div class="control-group">
                    <label class="control-label" for="form-parent">Parent</label>
                    <div class="controls">
                      <select name="parent" id="form-parent" class="span12">
                        <option value=""<?php if(empty($aCategoryEdit['parent'])){ echo ' selected="selected"'; } ?>None</option>
                        <?php foreach($aCategories as $aCategory): ?>
                          <option value="<?= $aCategory['id'] ?>"<?php if($aCategoryEdit['parent']['id'] == $aCategory['id']){ echo ' selected="selected"'; } ?>><?= $aCategory['name'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div> -->

                  <input type="submit" value="Save Changes" class="btn btn-primary">
                  <input type="hidden" name="id" value="<?= $aCategoryEdit['id'] ?>">
                </form>
              </div>
            </div>
          </div>
        <?php else: ?>
          <div class="accordion-group">
            <div class="accordion-heading">
              <span class="accordion-toggle">Create Category</span>
            </div>
            <div class="accordion-body in collapse">
              <div class="accordion-inner">
                <form id="add-form" method="post" action="/admin/portfolio/categories/add/s/">
                  <div class="control-group">
                    <label class="control-label" for="form-name">Name</label>
                    <div class="controls">
                      <input type="text" name="name" id="form-name" value="" class="span12 validate[required]"><br />
                    </div>
                  </div>

                  <!-- <div class="control-group">
                    <label class="control-label" for="form-parent">Parent</label>
                    <div class="controls">
                      <select name="parent" id="form-parent" class="span12">
                        <option value="">None</option>
                        <?php foreach($aCategories as $aCategory): ?>
                          <option value="<?= $aCategory['id'] ?>"><?= $aCategory['name'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div> -->

                  <input type="submit" value="Create Category" class="btn btn-primary">
                </form>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>

{footer}
<script>
$(function(){
  jQuery('#add-form').validationEngine({ promptPosition: "bottomLeft" });
  jQuery('#edit-form').validationEngine({ promptPosition: "bottomLeft" });

  $('.data-table').dataTable({
    /* DON'T CHANGE */
    "sDom": '<"dataTable-header"rf>t<"dataTable-footer"lip<"clear">',
    "sPaginationType": "full_numbers",
    "bLengthChange": false,
    /* CAN CHANGE */
    "bStateSave": true,
    "iDisplayLength": 10, //how many items to display per page
    {if $sSort == "manual"}
      "aaSorting": [[1, "asc"]], //which column to sort by (0-X)
      "aoColumns": [
        null,
        { "sType": "numeric" },
        null
      ]
    {else}
      "aaSorting": [[0, "asc"]] //which column to sort by (0-X)
    {/if}
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
});
</script>
{/footer}

<?php $this->tplDisplay("inc_footer.php"); ?>
