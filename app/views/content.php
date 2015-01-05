<?php $this->tplDisplay("inc_header.php", ['menu'=>$aContent['tag'],'sPageTitle'=>$aContent['title']]); ?>

	<div class="row page-title">
		<h1><?php echo $aContent['title'] ?></h1>
		<span class="subtitle"><?php echo $aContent['subtitle'] ?></span>
	</div>

	<div class="row">
		<div class="single-column content-block">
			<?php echo $aContent['content'] ?>
		</div>
	</div>

<?php $this->tplDisplay("inc_footer.php"); ?>
