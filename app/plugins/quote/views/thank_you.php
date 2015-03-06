<!--
@Name: Request Quote Thank You
@Description: Content template for the thank you page.
@Version: 1.0
@Restricted: true
@Author: Monkee-Boy
-->

<?php $this->tplDisplay("inc_header.php", ['menu'=>'work-with-us', 'sPageTitle'=>$aContent['title'];, 'seo_title'=>$aContent['seo_title'], 'seo_description'=>$aContent['seo_description'], 'seo_keywords'=>$aContent['seo_keywords']]); ?>

  <div class="row full">
    <div class="page-title">
      <h1><?= $aContent['title']; ?></h1>
      <p class="subtitle"><?= $aContent['subtitle']; ?></p>
    </div>
  </div>

  <div class="row">
    <div class="single-column content-block">
      <?= $aContent['content']; ?>
    </div>
  </div>

<?php $this->tplDisplay("inc_footer.php"); ?>
