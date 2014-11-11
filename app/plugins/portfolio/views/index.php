<?php echo '<pre>'; print_r($aPortfolio); ?>
<?php $this->tplDisplay("inc_header.php", ['menu'=>'portfolio']); ?>

  <div class="row">
    <div class="page-title">
      <h1>Balcones Pain Consultants</h1>
      <p class="subtitle">responsive redesign lorem ipsum dolor et al con laboris</p>
    </div>
  </div>


  <div class="row">

    <div class="port-slider" data-site="balcones">
      <div class="screens initial">
        <div class="tablet screen horizontal" data-device="tablet">
          <div class="screen-inner">
            <img src="/assets/port-balcones-tablet-home.png">
          </div>
        </div>
      </div><!-- /.screens -->
      <div class="thumbs">
        <span class="instructions">please pick a screen to the right to view in the device above</span>
        <a href="#" class="thumbnail active" data-screen="home">
          <img src="/images/temp-port-screen1.jpg" alt="Home Page">
        </a>
        <a href="#" class="thumbnail" data-screen="sub1">
          <img src="/images/temp-port-screen2.jpg" alt="Sub Page 1">
        </a>
        <a href="#" class="thumbnail" data-screen="sub2">
          <img src="/images/temp-port-screen3.jpg" alt="Sub Page 2">
        </a>
      </div>
    </div><!-- /.port-slider -->

  </div>

  <div class="row">
    <div class="full">
      <h2 data-text-align="center">Services Provided</h2>
      <ul class="service-icons portfolio">
        <li><span class="strategy service-icon"><i></i></span>Research &amp; Strategy</li>
        <li><span class="design service-icon"><i></i></span>Design</li>
        <li><span class="development service-icon"><i></i></span>Development</li>
        <li><span class="marketing service-icon"><i></i></span>Marketing</li>
        <li><span class="maintenance service-icon"><i></i></span>Maintenance</li>
        <li><span class="growth service-icon"><i></i></span>Growth</li>
      </ul>
    </div>
  </div>

  <div class="row">
    <div class="single-column">
      <h3 data-text-align="center">Other key services:</h3>

      <div class="row-pop">
        <div class="half">
          <h4>User Testing</h4>

          <p>Senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p>
        </div>

        <div class="half">
          <h4>Photography</h4>

          <p>Senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p>
        </div>
      </div>

      <div class="row row-pop">
        <div class="half">
          <h4>Custom CMS</h4>

          <p>Senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p>
        </div>
      </div>

      <div class="row">
        <ul class="unstyled quote-slider">
          <li><blockquote>“Vivamus sagittis lacus vel augue laore rutrum faucibus dolor auctor. Maecenas sed diam eget risus varius con blandit sit amet non magna. Nullam quis risus eget urna mollis ornare vel eu leo.”</blockquote></li>
          <li><blockquote>“Senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.”</blockquote></li>
          <li><blockquote>“Donec eu libero sit amet quam egestas semper.”</blockquote></li>
        </ul>
      </div>
    </div><!-- /.single-column -->
  </div>

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
