<?php $this->tplDisplay("inc_header.php", ['menu'=>'galleries','sPageTitle'=>"Galleries"]); ?>

	<h1>Manage Galleries <a class="btn btn-primary pull-right" href="/admin/galleries/categories/" title="Manage Categories" rel="tooltip" data-placement="bottom">Manage Categories</a><a class="btn btn-primary pull-right" href="/admin/galleries/add/" title="Add Gallery" rel="tooltip" data-placement="bottom"><i class="icon-plus icon-white"></i> Add Gallery</a></h1>
	<?php $this->tplDisplay('inc_alerts.php'); ?>

	<table class="data-table table table-striped">
		<thead>
			<tr>
				<th class="empty" style="width:80px !important;">&nbsp;</th>
				<th>Name</th>
				<th>Photos</td>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($aGalleries as $aGallery): ?>
				<tr>
					<td style="width:80px !important;">
						<span class="hidden"><?= $aGallery['sort_order'] ?></span>
						<?php if($aGallery['sort_order'] != 1): ?>
							<a href="/admin/galleries/sort/<?= $aGallery['id'] ?>/up/" title="Move Up One"><img src="/images/icons/bullet_arrow_up.png"></a>
						<?php else: ?>
							<img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" style="width:16px;height:16px;">
						<?php endif; ?>
						<?php if($aGallery['sort_order'] != $maxsort): ?>
							<a href="/admin/galleries/sort/<?= $aGallery['id'] ?>/down/" title="Move Down One"><img src="/images/icons/bullet_arrow_down.png"></a>
						<?php else: ?>
							<img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" style="width:16px;height:16px;">
						<?php endif; ?>
					</td>
					<td><?= $aGallery['name'] ?></td>
					<td class="center"><?= (!empty($aGallery['photos']))?count($aGallery['photos']):'No Photos' ?></td>
					<td class="center">
						<a href="/admin/galleries/<?= $aGallery['id'] ?>/photos/" title="Manage Gallery">
							<img src="/images/icons/pictures.png" alt="manage gallery">
						</a>
						<a href="/admin/galleries/edit/<?= $aGallery['id'] ?>/" title="Edit Gallery" rel="tooltip"><i class="icon-pencil"></i></a>
						<a href="/admin/galleries/delete/<?= $aGallery['id'] ?>/" title="Delete Gallery" rel="tooltip" onclick="return confirm_('Are you sure you would like to delete: <?= $aGallery['name'] ?>?');"><i class="icon-trash"></i></a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

{footer}
<script src="/scripts/dataTables/jquery.dataTables.min.js"></script>
<script src="/scripts/dataTables/plugins/paging-plugin.js"></script>
<script type="text/javascript">
	$(function(){
		$('.dataTable').dataTable({
			/* DON'T CHANGE */
			"sDom": 'rt<"dataTable-footer"flpi<"clear">',
			"sPaginationType": "scrolling",
			"bLengthChange": true,
			/* CAN CHANGE */
			"bStateSave": true, //whether to save a cookie with the current table state
			"iDisplayLength": 10, //how many items to display on each page
			"aaSorting": [[0, "asc"]] //which column to sort by (0-X)
		});
	});
</script>
{/footer}

<?php $this->tplDisplay("inc_footer.php"); ?>
