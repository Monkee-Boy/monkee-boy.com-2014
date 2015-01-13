<!--
@Name: Request Quote Form
@Description: Content template that includes the form for requesting a quote.
@Version: 1.0
@Restricted: true
@Author: Monkee-Boy
-->

<?php
if(!empty($aContent)) {
  $sTitle = $aContent['title'];
  $sSubtitle = $aContent['subtitle'];
} else {
  $sTitle = "Work With Us";
  $sSubtitle = "Let's start a dialogue. Just fill out the form below.";
}

$this->tplDisplay("inc_header.php", ['menu'=>'work-with-us', 'sPageTitle'=>$sTitle, 'seo_title'=>$aContent['seo_title'], 'seo_description'=>$aContent['seo_description'], 'seo_keywords'=>$aContent['seo_keywords']]); ?>

  <div class="row full">
    <div class="page-title">
      <h1><?php echo $sTitle; ?></h1>
      <p class="subtitle"><?php echo $sSubtitle; ?></p>
    </div>
  </div>

  <div class="row">
    <div class="single-column content-block">
      <?= $aContent['content']; ?>
    </div>
  </div>

<?php $this->tplDisplay("inc_footer.php"); ?>
