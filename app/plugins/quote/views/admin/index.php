<?php $this->tplDisplay("inc_header.php", ['menu'=>'quote','sPageTitle'=>"Work With Us"]); ?>

<h2>View Work With Us Submissions</h2>

<table  class="data-table table table-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th>Organization</th>
      <th>Submitted</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($aQuotes as $aQuote): ?>
      <tr>
        <td><a href="/admin/quote/view/<?= $aQuote['id'] ?>/" title="View Quote" rel="tooltip"><?= $aQuote['name'] ?></a></td>
        <td><?= $aQuote['organization'] ?></td>
        <td><?= date("m/d/Y g:ia", $aQuote['created_datetime']) ?></td>
        <td class="center">
          <a href="/admin/quote/view/<?= $aQuote['id'] ?>/" title="View Quote" rel="tooltip"><i class="icon-eye-open"></i></a>
          <a href="/admin/quote/delete/<?= $aQuote['id'] ?>/" title="Delete Quote" rel="tooltip" onclick="return confirm('Are you sure you would like to delete quote from: <?= $aQuote['name'] ?>?');"><i class="icon-trash"></i></a>
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
    "aaSorting": [[ 1, "asc" ]], //which column to sort by (0-X)
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
