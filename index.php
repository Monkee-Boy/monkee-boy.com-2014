<?php include('inc_header.php'); ?>

  <div class="row">
    <p class="subtitle">We're a web design &amp; marketing agency that loves process.</p>
  </div>

  <div class="hero-circles">
    <div class="row">
      <h1>Let's build something <i>amazing</i> together.</h1>
      <ul>
        <li>
          <span class="border"></span>
          <div class="discover circle" data-name="discover">
            <div class="bg" style="background-image:url(/images/home-discover.png)" data-bg="/images/home-discover.png"></div>
          </div>
          <p class="tagline first">
            <span class="title">Discover</span>
            <span class="subtitle">Strategy <span>+</span> Long Meetings</span>
          </p>
        </li>
        <li>
          <span class="border"></span>
          <div class="create circle" data-name="create">
            <div class="bg" style="background-image:url(/images/home-create.png)" data-bg="/images/home-create.png"></div>
          </div>
          <p class="tagline second">
            <span class="title">Create</span>
            <span class="subtitle">Design <span>+</span> Code</span>
          </p>
        </li>
        <li>
          <span class="border"></span>
          <div class="evolve circle" data-name="evolve">
            <div class="bg" style="background-image:url(/images/home-evolve.png)" data-bg="/images/home-evolve.png"></div>
          </div>
          <p class="tagline third">
            <span class="title">Evolve</span>
            <span class="subtitle">Maintenance <span>+</span> Growth</span>
          </p>
        </li>
      </ul>
    </div>
    <div class="circle-expander">
      <span class="bg"></span>
      <div class="title-overlay"></div>
      <a href="#" class="close-btn">Close</a>
      <div class="expander-nav">
        <a href="#" class="discover">Discover</a>
        <a href="#" class="create">Create</a>
        <a href="#" class="evolve">Evolve</a>
      </div>
    </div>
  </div>

  <div class="panel-wide">
    <div class="row-flush">
      Marketing Section
    </div>
  </div>

  <div class="panel-wide home-clients" data-panel-color="green" data-panel-style="slash">
    <div class="row section-head" data-text-align="right">
      <span class="section-title dots" data-dots="left"><em>a few of our</em> lovely clients</span>
    </div>

    <div class="row-flush">
      <ul class="featured-clients styleless">
        <li><a href="" title=""><img src="/assets/client-bullock.png" alt=""></a></li>
        <li><a href="" title=""><img src="/assets/client-austinchamber.png" alt=""></a></li>
        <li><a href="" title=""><img src="/assets/client-bullock.png" alt=""></a></li>
        <li><a href="" title=""><img src="/assets/client-austinchamber.png" alt=""></a></li>
      </ul>
    </div>
  </div>

  <div class="panel-wide home-pulse" data-panel-color="teal">
    <div class="row section-head" data-text-align="left">
      <span class="section-title dots" data-dots="right"><em>the</em><br />pulse</span>
    </div>

    <div class="row-flush">
      <div class="one-third item-panel">
        <h4>Latest News</h4>

        <div class="item-panel-inside" data-text-align="center">
          <figure><img src="/assets/news-icon.png" alt=""></figure>

          <p><a href="#" title="">Former Superhero joins team Monkee-Boy »</a></p>
          <time>09-03</time>
        </div>
      </div>

      <div class="one-third item-panel alt">
        <h4>Sign Up For Our Newsletter</h4>

        <div class="item-panel-inside" data-text-align="center">
          <form class="form-newsletter" action="" method="post">
            <div class="subscribe-status success"></div>

            <label for="form-email">Enter your email</label>
            <input type="email" name="email" id="form-email">
            <input type="submit" value="Subscribe!">
          </form>
        </div>
      </div>

      <div class="one-third item-panel">
        <h4>On Twitter</h4>

        <div class="item-panel-inside">
          [insert twitter widget]
        </div>
      </div>
    </div>
  </div>

  <div class="panel-wide home-blog" data-panel-color="light-grey">
    <div class="row section-head" data-text-align="center">
      <span class="section-title dots" data-dots="dual">from the blog</span>
    </div>

    <div class="row-flush">
      [lorem ipsum]
    </div>
  </div>

<?php include('inc_footer.php'); ?>
