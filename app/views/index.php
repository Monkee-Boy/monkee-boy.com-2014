<?php $this->tplDisplay("inc_header.php", ['menu'=>'home']); ?>

  <div class="row">
    <p class="subtitle hero-subtitle" data-text-align="center">We're a web design &amp; marketing agency that loves process.</p>
  </div>

  <div class="hero-circles">
    <div class="row">
      <h1>Let's build something <i>amazing</i> together.</h1>
      <div class="mobile-slider"></div>
      <ul>
        <li>
          <span class="border"></span>
          <div class="discover circle" data-name="discover">
            <div class="bg" style="background-image:url(/images/home-discover.png)" data-bg="/images/home-discover.png"></div>
          </div>
          <p class="tagline first">
            <a href="/our-process/discover/">
              <span class="title closed"><?= $this->getSetting('homepage-slider-discover-title'); ?></span>
              <span class="title open"><?= $this->getSetting('homepage-slider-discover-title-open'); ?></span>
              <span class="subtitle"><?= $this->getSetting('homepage-slider-discover-text'); ?></span>
            </a>
          </p>
        </li>
        <li>
          <span class="border"></span>
          <div class="create circle" data-name="create">
            <div class="bg" style="background-image:url(/images/home-create.png)" data-bg="/images/home-create.png"></div>
          </div>
          <p class="tagline second">
            <a href="/our-process/create/">
              <span class="title closed"><?= $this->getSetting('homepage-slider-create-title'); ?></span>
              <span class="title open"><?= $this->getSetting('homepage-slider-create-title-open'); ?></span>
              <span class="subtitle"><?= $this->getSetting('homepage-slider-create-text'); ?></span>
            </a>
          </p>
        </li>
        <li>
          <span class="border"></span>
          <div class="evolve circle" data-name="evolve">
            <div class="bg" style="background-image:url(/images/home-evolve.png)" data-bg="/images/home-evolve.png"></div>
          </div>
          <p class="tagline third">
            <a href="/our-process/evolve/">
              <span class="title closed"><?= $this->getSetting('homepage-slider-evolve-title'); ?></span>
              <span class="title open"><?= $this->getSetting('homepage-slider-evolve-title-open'); ?></span>
              <span class="subtitle"><?= $this->getSetting('homepage-slider-evolve-text'); ?></span>
            </a>
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

  <div class="home-portfolio">
    <div class="row-flush">
      <div class="half">
        <div class="section-head" data-text-align="left">
          <span class="section-title dots" data-dots="right"><em>featured from the</em><br>portfolio</span>
          <h3>Balcones Pain Consultants Redesign</h3>
          <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam et nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
          <ul class="menu-lite">
            <li><a href="#">View project</a></li>
            <li><a href="#">View full portfolio</a></li>
          </ul>
          <ul class="service-icons text-hover">
            <li><span class="strategy service-icon"><i></i></span><span class="hover">Research &amp; Strategy</span></li>
            <li><span class="design service-icon"><i></i></span><span class="hover">Design</span></li>
            <li><span class="development service-icon"><i></i></span><span class="hover">Development</span></li>
            <li><span class="marketing service-icon"><i></i></span><span class="hover">Marketing</span></li>
            <li><span class="maintenance service-icon"><i></i></span><span class="hover">Maintenance</span></li>
            <li><span class="growth service-icon"><i></i></span><span class="hover">Growth</span></li>
          </ul>
        </div>
      </div><!-- /.half -->
    </div>
    <div class="desktop screen">
      <div class="screen-inner">
        <img src="/assets/port-balcones-desktop-home.png">
      </div>
    </div>
  </div><!-- /.home-portfolio -->

  <div class="panel-wide home-marketing" data-panel-style="callout">
    <div class="row-flush">
      <div class="item-callout">
        <h3 data-text-align="center">monkee-boy<br />marketing section</h3>

        <p><em>Nullam quis risus eget urna mollis ornare vel eu leo.  Duis mollis, est non commodo luctus, nisi nec elit.
ante venenatis.</em></p>

        <ul class="list-style-alt">
          <li><a href="" title="">Lorem ipsum dolor sit amet &raquo;</a></li>
          <li><a href="" title="">Consectetuer adipiscing elit &raquo;</a></li>
          <li><a href="" title="">Sed diam nonummy nibh euismod &raquo;</a></li>
          <li><a href="" title="">Duis mollis, est non commodo &raquo;</a></li>
          <li><a href="" title="">Sed posuere  lobortis. &raquo;</a></li>
        </ul>
      </div>

      <div class="item-panel">
        <h3>lorem ipsum Ut enim ad minim veniam</h3>

        <p>Quis nostrud exercitation ullamco laboris nisi ut con aliquip ex ea commodo consequat.</p>

          <a href="" title="">Link to take it there</a>
      </div>
    </div>
  </div>

  <div class="panel-wide home-clients" data-panel-color="green" data-panel-style="slash">
    <div class="row section-head" data-text-align="right">
      <span class="section-title full dots" data-dots="left"><em>a few of our</em> lovely clients</span>
    </div>

    <div class="row-flush">
      <ul class="featured-clients styleless">
        <?php
        $oClient = $this->loadModel('clients');
        $aClients = $oClient->getClients(false, true, true);

        // Shuffle client array and fetch first 4
        shuffle($aClients);
        $aClients = array_slice($aClients, 0, 4);

        foreach($aClients as $aClient): ?>
          <li><a href="/client-list/" title="<?= $aClient['name'] ?>"><img src="<?= $aClient['logo_svg_url'] ?>" alt="<?= $aClient['name'] ?>"></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <div class="panel-wide home-pulse" data-panel-color="teal">
    <div class="row section-head" data-text-align="left">
      <span class="section-title full dots" data-dots="right"><em>the</em><br />pulse</span>
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

  <!-- <div class="panel-wide home-blog" data-panel-color="light-grey">
    <div class="row section-head" data-text-align="center">
      <span class="section-title dots" data-dots="dual">from the blog</span>
    </div>

    <div class="row-flush">
      <div class="one-third post-panel" data-text-align="center">
        <div class="post-panel-inside">
          <a href="" title=""><img src="/assets/blog-post.jpg" alt=""></a>
          <h4><a href="" title="">Freebie Friday: 25 Colorful Polygon Backgrounds</a></h4>
        </div>
      </div>

      <div class="one-third post-panel" data-text-align="center">
        <div class="post-panel-inside">
          <a href="" title=""><img src="/assets/blog-post.jpg" alt=""></a>
          <h4><a href="" title="">Freebie Friday: 25 Colorful Polygon Backgrounds</a></h4>
        </div>
      </div>

      <div class="one-third post-panel" data-text-align="center">
        <div class="post-panel-inside">
          <a href="" title=""><img src="/assets/blog-post.jpg" alt=""></a>
          <h4><a href="" title="">Freebie Friday: 25 Colorful Polygon Backgrounds</a></h4>
        </div>
      </div>
    </div>
  </div> -->

<?php $this->tplDisplay("inc_footer.php"); ?>
