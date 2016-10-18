<?php
$this->tplDisplay("inc_header.php", ['menu'=>'portfolio', 'page_title'=>$aClient['name'], 'seo_title'=>$aClient['seo_title'], 'seo_description'=>$aClient['seo_description'], 'seo_keywords'=>$aClient['seo_keywords'], 'og_image'=>((!empty($aClient['listing_image']))?$aClient['listing_image_url']:$aClient['logo_url'])]);
?>

  <div class="row">
    <div class="page-title">
      <h1><?= $aClient['name']; ?></h1>
      <p class="subtitle"><?= $aClient['subtitle']; ?></p>
    </div>
  </div> <!-- /.row -->

  <?php $this->tplDisplay('inc_subnav.php', array('menu' => 'portfolio', 'nav' => 'work')); ?>

  <?php if(count($aClient['slides']) > 0): ?>
  <?php $slides = 0; ?>
  <div class="row">
    <div class="port-slider" data-site="site">
      <div class="screens initial">
        <?php if(!empty($aClient['slides'][0]['desktop_image_url'])): ?>
        <div class="desktop screen active" data-device="desktop">
          <div class="screen-inner">
            <img src="<?= $aClient['slides'][0]['desktop_image_url']; ?>">
            <div class="scroll-msg"><span>Want to see it all?</span> Scroll Here</div>
          </div>
        </div> <!-- /.desktop.screen -->
        <?php $slides++; endif; ?>

        <?php if(!empty($aClient['slides'][0]['tablet_image_url'])): ?>
        <div class="tablet screen right<?php if($aClient['type'] == 3){ echo ' horizontal'; } ?>" data-device="tablet">
          <div class="screen-inner">
            <img src="<?= $aClient['slides'][0]['tablet_image_url']; ?>">
          </div>
        </div> <!-- /.tablet-screen -->
        <?php $slides++; endif; ?>

        <?php if(!empty($aClient['slides'][0]['phone_image_url'])): ?>
        <div class="phone screen left" data-device="phone">
          <div class="screen-inner">
            <img src="<?= $aClient['slides'][0]['phone_image_url']; ?>">
          </div>
        </div> <!-- /.phone -->
        <?php $slides++; endif; ?>

        <?php if($slides > 1): ?>
        <div class="slider-nav">
          <a href="#" class="port-left">Rotate Left</a>
          <a href="#" class="port-right">Rotate Right</a>
        </div><!-- /.slider-nav -->
        <?php endif; ?>
      </div><!-- /.screens -->

      <div class="thumbs">
        <span class="instructions">want to see more? select a screen to load it in the devices above.</span>

        <div class="thumbs-slider">
          <?php foreach($aClient['slides'] as $aSlide) { ?>
            <div>
              <a href="#" class="thumbnail" data-screen-desktop="<?= $aSlide['desktop_image_url']; ?>" data-screen-tablet="<?= $aSlide['tablet_image_url']; ?>" data-screen-phone="<?= $aSlide['phone_image_url']; ?>">
                <img src="<?= $aSlide['listing_image_url']; ?>" alt="">
              </a>
            </div>
          <?php } ?>
        </div> <!-- /.thumbs-slider -->
      </div> <!-- /.thumbs -->
    </div> <!-- /.port-slider -->
  </div> <!-- /.row -->
  <?php endif; ?>

  <div class="row vspace-extra">
    <h2 data-text-align="center" class="fancy"><span>Project Highlights</span></h2>

    <div class="row-pop">
      <div class="one-third">
        <?= $aClient['other_services_1']; ?>
      </div>

      <div class="one-third">
        <?= $aClient['other_services_2']; ?>
      </div>

      <div class="one-third">
        <?= $aClient['other_services_3']; ?>
      </div>
    </div>

    <div class="single-column">
      <div class="row">
        <ul class="unstyled quote-slider">
          <?php if(!empty($aClient['quotes'])) {
            foreach($aClient['quotes'] as $aQuote) { ?>
              <li>
                <blockquote>
                  <?= $aQuote['quote']; ?>
                  <footer><?= $aQuote['attribution']; ?></footer>
                </blockquote>
              </li>
          <?php }
          } ?>
        </ul>
      </div>
    </div><!-- /.single-column -->
  </div>

  <?php if(!empty($aClient['gallery'])): ?>
    <?php if(!empty($aClient['gallery']['photos'])): ?>
    <div class="fullwidth-slider">
      <ul class="unstyled">
        <?php foreach($aClient['gallery']['photos'] as $aPhoto): ?>
        <li>
          <figure>
            <div class="slick-photo-wrapper">
              <img src="/uploads/galleries/<?= $aClient['gallery']['id'] ?>/<?= $aPhoto['photo'] ?>" alt="<?= $aPhoto['title'] ?>">
            </div>
            <figcaption><?= $aPhoto['description'] ?></figcaption>
          </figure>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
  <?php endif; ?>

  <div class="main-cta">
    <div class="row">
      <div class="cta-inner">
        <p>Ready to Start Working Together?</p>
      </div>

      <div class="cta-button">
        <a href="/contact/request-a-quote/" title="CTA Button" class="button">Let's Get In Touch!</a>
      </div>
    </div>
  </div>

<?php $this->tplDisplay("inc_footer.php"); ?>
