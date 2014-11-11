<?php //echo '<pre>'; print_r($aClient); ?>
<?php $this->tplDisplay("inc_header.php", ['menu'=>'portfolio']); ?>

  <div class="row">
    <div class="page-title">
      <h1><?php echo $aClient['name']; ?></h1>
      <p class="subtitle"><?php echo $aClient['subtitle']; ?></p>
    </div>
  </div> <!-- /.row -->

  <div class="row">
    <div class="port-slider" data-site="site">
      <div class="screens initial">
        <div class="desktop screen active" data-device="desktop">
          <div class="screen-inner">
            <img src="<?php echo $aClient['slides'][0]['desktop_image_url']; ?>">
            <div class="scroll-msg"><span>Want to see it all?</span> Scroll Here</div>
          </div>
        </div> <!-- /.desktop.screen -->

        <div class="tablet screen right" data-device="tablet">
          <div class="screen-inner">
            <img src="<?php echo $aClient['slides'][0]['tablet_image_url']; ?>">
          </div>
        </div> <!-- /.tablet-screen -->

        <div class="phone screen left" data-device="phone">
          <div class="screen-inner">
            <img src="<?php echo $aClient['slides'][0]['phone_image_url']; ?>">
          </div>
        </div> <!-- /.phone -->

        <div class="slider-nav">
          <a href="#" class="port-left">Rotate Left</a>
          <a href="#" class="port-right">Rotate Right</a>
        </div><!-- /.slider-nav -->
      </div><!-- /.screens -->

      <div class="thumbs">
        <span class="instructions">please pick a screen to the right to view in the device above</span>

        <?php foreach($aClient['slides'] as $aSlide) { ?>
        <a href="#" class="thumbnail active" data-screen="<?php echo $aSlide['id']; ?>">
          <img src="<?php echo $aSlide['listing_image_url']; ?>" alt="">
        </a>
        <?php } ?>
      </div> <!-- /.thumbs -->
    </div><!-- /.port-slider -->
  </div> <!-- /.row -->

  <div class="row">
    <div class="full">
      <h2 data-text-align="center">Services Provided</h2>
      <ul class="service-icons portfolio">
        <?php foreach($aClient['services'] as $aService) { ?>
        <li><span class="<?php echo $aService['tag']; ?> service-icon"><i></i></span><?php echo $aService['name']; ?></li>
        <?php } ?>
      </ul>
    </div> <!-- /.full -->
  </div> <!-- /.row -->

  <div class="row">
    <div class="single-column">
      <h3 data-text-align="center">Other key services:</h3>

      <div class="row-pop">
        <div class="half">
          <?php echo $aClient['other_services_1']; ?>
        </div>

        <div class="half">
          <?php echo $aClient['other_services_2']; ?>
        </div>
      </div>

      <div class="row">
        <ul class="unstyled quote-slider">
          <?php if(!empty($aClient['quotes'])) {
            foreach($aClient['quotes'] as $aQuote) { ?>
              <li><blockquote><?php echo $aQuote['quote']; ?></blockquote></li>
          <?php }
          } ?>
        </ul>
      </div>
    </div><!-- /.single-column -->
  </div>

  <!-- TODO: Add this to the CMS. -->
  <div class="fullwidth-slider">
    <ul class="unstyled">
      <li>
        <figure>
          <img src="/assets/waithappy-sample1.jpg" alt="">
          <figcaption>Caption lorem dolor sit amet, consectetur adipiscing elit. Fusce dapibus, tellus ac cursus commodo.</figcaption>
        </figure>
      </li>
      <li>
        <figure>
          <img src="/assets/waithappy-sample2.jpg" alt="">
          <figcaption>Caption lorem dolor sit amet, consectetur adipiscing elit. Fusce dapibus, tellus ac cursus commodo.</figcaption>
        </figure>
      </li>
      <li>
        <figure>
          <img src="/assets/waithappy-sample3.jpg" alt="">
          <figcaption>Caption lorem dolor sit amet, consectetur adipiscing elit. Fusce dapibus, tellus ac cursus commodo.</figcaption>
        </figure>
      </li>
      <li>
        <figure>
          <img src="/assets/waithappy-sample1.jpg" alt="">
          <figcaption>Caption lorem dolor sit amet, consectetur adipiscing elit. Fusce dapibus, tellus ac cursus commodo.</figcaption>
        </figure>
      </li>
      <li>
        <figure>
          <img src="/assets/waithappy-sample2.jpg" alt="">
          <figcaption>Caption lorem dolor sit amet, consectetur adipiscing elit. Fusce dapibus, tellus ac cursus commodo.</figcaption>
        </figure>
      </li>
      <li>
        <figure>
          <img src="/assets/waithappy-sample3.jpg" alt="">
          <figcaption>Caption lorem dolor sit amet, consectetur adipiscing elit. Fusce dapibus, tellus ac cursus commodo.</figcaption>
        </figure>
      </li>
    </ul>
  </div>

<?php $this->tplDisplay("inc_footer.php"); ?>
