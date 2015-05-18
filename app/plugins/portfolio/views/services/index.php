<?php $this->tplDisplay("inc_header.php", ['menu'=>'services', 'page_title'=>$aServiceContent['title'], 'seo_title'=>$aServiceContent['seo_title'], 'seo_description'=>$aServiceContent['seo_description'], 'seo_keywords'=>$aServiceContent['seo_keywords']]); ?>

  <div class="row">
    <div class="page-title">
      <h1><?= $aServiceContent['title'] ?></h1>
      <p class="subtitle"><?= $aServiceContent['subtitle'] ?></p>
    </div> <!-- /.page-title -->
  </div> <!-- /.row -->

  <?php foreach($aServices as $aService) { ?>
  <div class="row">
    <div class="panel">
      <aside class="text-center">
        <a href="<?php echo $aService['url']; ?>" title="<?php echo $aService['title']; ?>"><img src="<?php echo (!empty($aService['image']))?$aService['image_url']:"http://www.fillmurray.com/g/436/328"; ?>"></a>

        <h2><?php echo $aService['name']; ?></h2>
      </aside>

      <div class="panel-content">
        <h4><a href="<?php echo $aService['url']; ?>" title="<?php echo $aService['title']; ?>"><?php echo $aService['subtitle']; ?> &raquo;</a></h4>

        <p><?php echo $aService['description']; ?></p>

        <a href="<?php echo $aService['url']; ?>" title="View These Services" class="button button-alt button-full">View These Services!</a>
      </div>
    </div>
  </div> <!-- /.row -->
  <?php } ?>

<?php $this->tplDisplay("inc_footer.php"); ?>
