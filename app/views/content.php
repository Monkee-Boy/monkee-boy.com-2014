<?php $this->tplDisplay("inc_header.php", ['menu'=>$aContent['tag'],'sPageTitle'=>$aContent['title']]); ?>

	<h2><?php echo $aContent['title'] ?></h2>
	<?php echo $aContent['content'] ?>

<?php $this->tplDisplay("inc_footer.php"); ?>
