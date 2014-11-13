<?php $this->tplDisplay("inc_header.php", ['menu'=>'galleries','sPageTitle'=>"Galleries &raquo; Photos"]); ?>

	<h1>Manage Galleries &raquo; Photos
		<a class="btn btn-primary pull-right" href="/admin/galleries/" title="Manage Galleries" rel="tooltip" data-placement="bottom">Manage Galleries</a>
		<a class="btn btn-primary pull-right" href="/admin/galleries/<?= $aGallery['id'] ?>/photos/add/" title="Add Photo" rel="tooltip" data-placement="bottom"><i class="icon-plus icon-white"></i> Add Photo</a>
	</h1>

	<table class="data-table table table-striped">
		<thead>
			<tr>
				<th class="empty" style="width:80px !important;">&nbsp;</th>
				<th style="width: 105px !important;">&nbsp;</th>
				<th>Title</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($aGallery['photos'] as $k=>$aPhoto): ?>
				<tr>
					<td style="width:80px !important;">
						<span class="hidden"><?= $aPhoto['sort_order'] ?></span>
						<?php if($aPhoto['sort_order'] != $minsort): ?>
							<a href="/admin/galleries/<?= $aGallery['id'] ?>/photos/sort/<?= $aPhoto['id'] ?>/up/" title="Move Up One"><img src="/images/icons/bullet_arrow_up.png"></a>
						<?php else: ?>
							<img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" style="width:16px;height:16px;">
						<?php endif; ?>
						<?php if($aPhoto['sort_order'] != $maxsort && $k != count($aGallery['photos'])): ?>
							<a href="/admin/galleries/<?= $aGallery['id'] ?>/photos/sort/<?= $aPhoto['id'] ?>/down/" title="Move Down One"><img src="/images/icons/bullet_arrow_down.png"></a>
						<?php else: ?>
							<img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" style="width:16px;height:16px;">
						<?php endif; ?>
					</td>
					<td style="width: 105px !important;"><img src="<?= $sImageFolder.$aGallery['id'].'/'.$aPhoto['photo'] ?>" style="max-width: 100px;max-height: 80px;"></td>
					<td><?= $aPhoto['title'] ?></td>
					<td class="center">
						<a href="/admin/galleries/<?= $aGallery['id'] ?>/photos/edit/<?= $aPhoto['id'] ?>/" title="Edit Photo"><i class="icon-pencil"></i></a>
						<a href="/admin/galleries/<?= $aGallery['id'] ?>/photos/delete/<?= $aPhoto['id'] ?>/" title="Delete Photo"><i class="icon-trash" onclick="return confirm_('Are you sure you would like to delete: <?= $aPhoto['title'] ?>?');"></i></a>
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
