<!--
@Name: Work With Us
@Description: Content template that includes by the numbers images.
@Version: 1.0
@Restricted: true
@Author: Monkee-Boy
-->

<?php
$aContent = getContent(null, "why-monkee-boy");
if(!empty($aContent)) {
  $sTitle = $aContent['title'];
  $sSubtitle = $aContent['subtitle'];
} else {
  $sTitle = "";
  $sSubtitle = "";
}

$this->tplDisplay("inc_header.php", ['menu'=>'why-monkee-boy', 'sPageTitle'=>$sTitle, 'seo_title'=>$aContent['seo_title'], 'seo_description'=>$aContent['seo_description'], 'seo_keywords'=>$aContent['seo_keywords']]); ?>

  <div class="row page-title">
    <h1><?php echo $sTitle; ?></h1>
    <p class="subtitle"><?php echo $sSubtitle; ?></p>
  </div>

  <div class="row">
    <div class="single-column content-block">
      <?php echo $aContent['content'] ?>
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
