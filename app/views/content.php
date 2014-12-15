<?php $this->tplDisplay("inc_header.php", ['menu'=>$aContent['tag'],'sPageTitle'=>$aContent['title']]); ?>

	<div class="row">
		<div class="page-title">
			<h1><?php echo $aContent['title'] ?></h1>
		</div>
	</div>

	<div class="row">
		<div class="full">
			<?php echo $aContent['content'] ?>
		</div>
	</div>

<?php $this->tplDisplay("inc_footer.php"); ?>
