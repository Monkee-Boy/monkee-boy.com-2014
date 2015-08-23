<?php $this->tplDisplay("inc_header.php", ['menu'=>'our-process', 'page_title'=>$aServiceContent['title'], 'seo_title'=>$aServiceContent['seo_title'], 'seo_description'=>$aServiceContent['seo_description'], 'seo_keywords'=>$aServiceContent['seo_keywords']]); ?>

  <div class="row">
    <div class="page-title">
      <h1><?= $aServiceContent['title'] ?></h1>
      <p class="subtitle"><?= $aServiceContent['subtitle'] ?></p>
    </div> <!-- /.page-title -->
  </div> <!-- /.row -->

  <?php $this->tplDisplay('inc_subnav.php', array('menu' => 'our-process', 'nav' => 'who')); ?>

  <div class="row">
		<div class="single-column content-block">
			<?php echo $aServiceContent['content'] ?>
		</div>
	</div>

  <?php foreach($aServices as $aService) { ?>
  <div class="row">
    <img src="<?php echo (!empty($aService['image']))?$aService['image_url']:"http://www.fillmurray.com/g/436/328"; ?>">

    <div class="panel service-panel">
      <div class="panel-content">
        <h2><?php echo $aService['name']; ?></h2>
        <h4><?php echo $aService['subtitle']; ?></h4>

        <p><?php echo $aService['description']; ?></p>
      </div>
    </div>
  </div> <!-- /.row -->
  <?php } ?>

<?php $this->tplDisplay("inc_footer.php"); ?>
