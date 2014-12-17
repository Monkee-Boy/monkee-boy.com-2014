<?php $this->tplDisplay("inc_header.php", ['menu'=>'testimonials','sPageTitle'=>"Testimonials"]); ?>

<h1>Testimonials <a class="btn btn-primary pull-right" href="/admin/testimonials/add/" title="Create a New Testimonial" rel="tooltip" data-placement="bottom"><i class="icon-plus icon-white"></i> Create Testimonial</a> <!-- <a class="btn btn-primary pull-right" href="/admin/testimonials/categories/" title="Manage Categories" rel="tooltip" data-placement="bottom"><i class="icon-plus icon-white"></i> Manage Categories</a> --></h1>
<?php $this->tplDisplay('inc_alerts.php'); ?>

<table class="data-table table table-striped">
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Client</th>
			<th>Name</th>
			<?php if($sSort == "manual"): ?>
			<th>Order</th>
			<?php endif; ?>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($aTestimonials as $aTestimonial): ?>
			<tr>
				<td class="data-table-status">
					<?php if($aTestimonial['active'] == 1): ?>
						<span class="hidden">active</span><img src="/images/icons/bullet_green.png" alt="active">
					<?php elseif($aTestimonial['active'] == 0): ?>
						<span class="hidden">inactive</span><img src="/images/icons/bullet_red.png" alt="inactive">
					<?php endif; ?>
				</td>
				<td><?= $aTestimonial['client'] ?></td>
				<td><?= $aTestimonial['name'] ?></td>
				<?php if($sSort == "manual"): ?>
				<td class="small center">
					<span class="hidden"><?= $aTestimonial['sort_order'] ?></span>
					<?php if($aTestimonial['sort_order'] != $minSort): ?>
						<a href="/admin/testimonials/sort/<?= $aTestimonial['id'] ?>/up/" title="Move Up One"><img src="/images/icons/bullet_arrow_up.png" style="width:16px;height:16px;"></a>
					<?php else: ?>
						<img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" style="width:16px;height:16px;">
					<?php endif; ?>
					<?php if($aTestimonial['sort_order'] != $maxSort && count($aTestimonial) > 1): ?>
						<a href="/admin/testimonials/sort/<?= $aTestimonial['id'] ?>/down/" title="Move Down One"><img src="/images/icons/bullet_arrow_down.png" style="width:16px;height:16px;"></a>
					<?php else: ?>
						<img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" style="width:16px;height:16px;">
					<?php endif; ?>
				</td>
			<?php endif; ?>
				<td class="center">
					<a href="/admin/testimonials/edit/<?= $aTestimonial['id'] ?>/" title="Edit Testimonial"><i class="icon-pencil"></i></a>
					<a href="/admin/testimonials/delete/<?= $aTestimonial['id'] ?>/" title="Delete Testimonial" onclick="return confirm('Are you sure you would like to delete this testimonial?');"><i class="icon-trash"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<ul class="data-table-legend">
	<li class="bullet-green">Active, published</li>
	<li class="bullet-yellow">Active, pending publish</li>
	<li class="bullet-red">Inactive, expired</li>
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
	"aaSorting": [[1, "asc"]], //which column to sort by (0-X)
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
