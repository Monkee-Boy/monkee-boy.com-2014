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

<div class="row">
  <div class="main-cta">
    <div class="cta-inner newsletter-inner">
      <p>Raise Your Digital IQ</p>
      <p>Get FREE advice every month from our troop of experts.</p>
      <form class="request-newsletter-form" name="request-newsletter" action="/" method="post">
        <span class="input-wrapper one-third">
          <input type="text" name="name" required>
          <label for="name">Name</label>
        </span>
        <span class="input-wrapper one-third">
          <input type="text" name="email" required>
          <label for="email">Email Address</label>
        </span>
        <span class="input-wrapper one-third">
          <button type="submit" class="submit">Join Now!</button>
        </span>
      </form>
      <p>(Monkees don't spam. We won't ever share your email address)</p>
    </div>
  </div>
</div>
