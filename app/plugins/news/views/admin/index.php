<?php $this->tplDisplay("inc_header.php", ['menu'=>'news','sPageTitle'=>"News"]); ?>

	<h1>News <a class="btn btn-primary pull-right" href="/admin/news/add/" title="Create a New Article" rel="tooltip" data-placement="bottom"><i class="icon-plus icon-white"></i> Create Article</a> <a class="btn btn-primary pull-right" href="/admin/news/categories/" title="Manage Categories" rel="tooltip" data-placement="bottom"><i class="icon-plus icon-white"></i> Manage Categories</a></h1>
	<?php $this->tplDisplay('inc_alerts.php'); ?>

	<table class="data-table table table-striped">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Title</th>
				<th>Publish On</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($aArticles as $aArticle): ?>
				<tr>
					<td class="data-table-status">
						<?php if($aArticle['active'] == 1 && $aArticle['publish_on'] < time()): ?>
							<span class="hidden">active</span><img src="/images/icons/bullet_green.png" alt="active">
						<?php elseif($aArticle['active'] == 0): ?>
							<span class="hidden">inactive</span><img src="/images/icons/bullet_red.png" alt="inactive">
						<?php else: ?>
							<span class="hidden">not published</span><img src="/images/icons/bullet_yellow.png" alt="not published">
						<?php endif; ?>
					</td>
					<td><a href="<?= $aArticle['url'] ?>" title="View <?= $aArticle['title'] ?>" target="_blank"><?= $aArticle['title'] ?></a></td>
					<td class="center"><?= formatDateTime($aArticle['publish_on']) ?></td>
					<td class="center">
						<a href="/admin/news/edit/<?= $aArticle['id'] ?>/" title="Edit Article" rel="tooltip"><i class="icon-pencil"></i></a>
						<a href="/admin/news/delete/<?= $aArticle['id'] ?>/" title="Delete Article" rel="tooltip" onclick="return confirm('Are you sure you would like to delete: <?= $aArticle['title'] ?>?');"><i class="icon-trash"></i></a>
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
