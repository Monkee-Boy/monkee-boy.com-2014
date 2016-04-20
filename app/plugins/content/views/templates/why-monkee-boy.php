<!--
@Name: Our Expertise
@Description: Content template that includes by the numbers images.
@Version: 1.0
@Restricted: false
@Author: Monkee-Boy
-->

<?php $this->tplDisplay("inc_header.php", ['menu'=>'our-approach', 'page_title'=>$sTitle, 'seo_title'=>$aContent['seo_title'], 'seo_description'=>$aContent['seo_description'], 'seo_keywords'=>$aContent['seo_keywords']]); ?>

  <div class="row page-title">
    <h1><?= $aContent['title']; ?></h1>
    <p class="subtitle"><?= $aContent['subtitle']; ?></p>
  </div>

  <?php $this->tplDisplay('inc_subnav.php', array('menu' => 'our-approach', 'nav' => 'who')); ?>

  <div class="row">
    <div class="single-column content-block">
      <?= $aContent['content']; ?>
    </div>
  </div>
  <div class="row">
    <div class="full">
      <?php for($i = 1; $i <= 7; $i++) {
        echo '<img src="/assets/numbers' . $i . '.png" alt="Monkee-Boy stats">';
      } ?>
    </div>
  </div>

<?php $this->tplDisplay("inc_footer.php"); ?>
