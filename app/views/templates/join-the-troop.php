<!--
@Name: Join the Troop
@Description: Content template that includes list of open positions.
@Version: 1.0
@Restricted: true
@Author: Monkee-Boy
-->

<?php
$aContent = getContent(null, "join-the-troop");
if(!empty($aContent)) {
  $sTitle = $aContent['title'];
  $sSubtitle = $aContent['subtitle'];
} else {
  $sTitle = "";
  $sSubtitle = "";
}

$this->tplDisplay("inc_header.php", ['menu'=>'join-the-troop', 'sPageTitle'=>$sTitle]); ?>

  <div class="row page-title">
      <h1><?php echo $sTitle; ?></h1>
      <p class="subtitle"><?php echo $sSubtitle; ?></p>
    </div>
  </div>

  <div class="row">
    <div class="single-column content-block">
      <?php echo $aContent['content'] ?>
    </div>
  </div>

  <div class="row">
    <div class="single-column content-block">
      <h2>Current Openings</h2>
      <p>Hmmm. It doesn't look like we currently have any open positions. But that doesn't mean we don't like you! Be the first to know when we're hiring by following us on Twitter or Facebook.</p>
      <p>Monkee-Boy is an Equal Opportunity/Affirmative Action Employer. We welcome and encourage diversity in our workplace – even Aggies are welcome!</p>
    </div>
  </div>

<?php $this->tplDisplay("inc_footer.php"); ?>
