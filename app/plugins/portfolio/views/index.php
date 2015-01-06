<?php $this->tplDisplay("inc_header.php", ['menu'=>'portfolio', 'page_title'=>$aServiceContent['title'], 'seo_title'=>$aServiceContent['seo_title'], 'seo_description'=>$aServiceContent['seo_description'], 'seo_keywords'=>$aServiceContent['seo_keywords']]); ?>

  <div class="row">
    <div class="page-title">
      <h1><?= $aServiceContent['title'] ?></h1>
      <p class="subtitle"><?= $aServiceContent['subtitle'] ?></p>
    </div>
  </div>

  <?php foreach($aPortfolio as $aClient) { ?>
  <div class="row">
    <div class="panel">
      <aside class="text-center">
        <img src="<?php echo (!empty($aClient['listing_image']))?$aClient['listing_image_url']:$aClient['logo_url']; ?>" alt="<?php echo $aClient['name']; ?> Logo">
      </aside>

      <div class="panel-content">
        <h4><?php echo $aClient['name']; ?></h4>

        <?php echo $aClient['short_description']; ?>

        <ul class="service-icons">
          <?php foreach($aClient['services'] as $aService) { ?>
          <li><span class="<?php echo $aService['tag']; ?> service-icon"><i></i></span></li>
          <?php } ?>
        </ul>

        <a href="<?php echo $aClient['url']; ?>" title="View The Project" class="button button-alt button-full">View the project!</a>
      </div>
    </div>
  </div>
  <?php } ?>

<?php $this->tplDisplay("inc_footer.php"); ?>
