<?php $this->tplDisplay("inc_header.php", ['menu'=>'settings','sPageTitle'=>"Plugins"]); ?>

	<h1>Plugins</h1>
	<?php $this->tplDisplay('inc_alerts.php'); ?>

	<table class="data-table table table-striped">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Plugin</th>
				<th>Description</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($aPlugins as $aPlugin): ?>
				<tr>
					<td class="data-table-status">
						<?php if($aPlugin['status'] == 1): ?>
							<img src="/images/icons/bullet_green.png" alt="active" width="16px">
						<?php else: ?>
							<img src="/images/icons/bullet_red.png" alt="inactive">
						<?php endif; ?>
					</td>
					<td><?= $aPlugin['name'] ?></td>
					<td>
						<?php if(!empty($aPlugin['description'])){ echo $aPlugin['description'].'<br /><br />'; } ?>
						Version <?= $aPlugin['version'] ?> | By
						<?php if(!empty($aPlugin['website'])){
							echo '<a href="'.$aPlugin['website'].'" title="'.$aPlugin['author'].'">';
						} ?> <?= $aPlugin['author'] ?> <?php if(!empty($aPlugin['website'])){ echo '</a>'; } ?>
					</td>
					<td>
						<?php if($aPlugin['status'] == 0): ?>
							<a href="/admin/settings/plugins/install/<?= $aPlugin['tag'] ?>/" title="Install <?= $aPlugin['name'] ?>"><i class="icon-plus-sign"></i></a>
						<?php else: ?>
							<a href="/admin/settings/plugins/uninstall/<?= $aPlugin['tag'] ?>/" onclick="return confirm('Are you sure you would like to uninstall <?= $aPlugin['name'] ?>?');" title="Uninstall <?= $aPlugin['name'] ?>"><i class="icon-minus-sign"></i></a>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<ul class="data-table-legend">
		<li class="bullet-green">Installed</li>
		<li class="bullet-red">Not Installed</li>
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
	"aaSorting": [[ 1, "asc" ]], //which column to sort by (0-X)
	"iDisplayLength": 10 //how many items to display per page
});
$('.dataTable-header').prepend('if($sSuperAdmin) { foreach($aAdminFullMenu as $k=>$aMenu) { if($k == $menu) { if(count($aMenu['menu'] > 1) { echo '<ul class="nav nav-pills">'; foreach($aMenu['menu'] as $aItem) { echo '<li'; if($subMenu == $aItem['text']){ echo ' class="active"'; } echo '><a href="'.$aItem['link'].'" title="'.$aItem['text'].'">'.$aItem.text.'</a></li>'; } echo '</ul>'; } } } } ?>');
</script>
{/footer}
<?php $this->tplDisplay("inc_footer.php"); ?>
