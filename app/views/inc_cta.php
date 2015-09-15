<?php
if(isset($service) && !empty($service)) {
  $service_select = '?service='.$service;
} else {
  $service_select = '';
}
?>

<div class="row">
  <div class="main-cta">
    <div class="cta-inner">
      <p><?= $line1 ?></p>
    </div>

    <div class="cta-button">
      <a href="/contact/request-a-quote/<?= $service_select; ?>" title="" class="button"><?= $button ?></a>
    </div>
  </div>
</div>
