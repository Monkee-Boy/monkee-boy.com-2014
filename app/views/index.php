<?php $this->tplDisplay("inc_header.php", ['menu'=>'home']); ?>

  <div class="hero-container">
    <div class="hero-bg"></div>

    <div class="hero-services">
      <div class="hero-inner">
        <div class="hero-content">
          <div class="hero-callout">
            <h1>Solve The Web</h1>

          </div>

          <div class="hero-detail">

            <p>Batman had Alfred. Sherlock had Watson. Luke had Yoda. Who is your trusted advisor? In the fast-paced world of the web, we know it's a jungle out there.</p>

            <p><strong>Nice to meet you! We're Monkee-Boy.</strong></p>
            <p><strong>We are experts in digital, turn heroes into superheroes, and can help you solve the web too.</strong></p>

          </div>
        </div> <!-- /.hero-content -->

        <div class="hero-service-list">
          <ul>
            <li><a href="/how-we-help/web-design-and-development/">Web Design and Development</a></li>
            <li><a href="/how-we-help/content-strategy/">Content Strategy</a></li>
            <li><a href="/how-we-help/analytics/">Analytics</a></li>
            <li><a href="/how-we-help/website-maintenance/">Website Maintenance</a></li>
            <li><a href="/how-we-help/content-marketing/">Content Marketing</a></li>
            <li><a href="/how-we-help/social-media/">Social Media</a></li>
            <li><a href="/how-we-help/seo/">SEO</a></li>
            <li><a href="/how-we-help/pay-per-click/">Pay-Per-Click</a></li>
          </ul>
        </div> <!-- /.hero-service-list -->
      </div> <!-- /.hero-inner -->
    </div> <!-- /.hero-services -->
  </div> <!-- /.hero-container -->

  <?php
  $oPortfolio = $this->loadModel('portfolio');
  $aPortfolio = $oPortfolio->getLatest();
  if(!empty($aPortfolio)):
  ?>
  <div class="home-portfolio">
    <div class="row-flush">
      <div class="half">
        <div class="section-head" data-text-align="left">
          <span class="section-title dots" data-dots="right"><em>featured from the</em><br>portfolio</span>
          <?php if(!empty($aPortfolio['slides'])): ?>
            <?php if(!empty($aPortfolio['slides'][0]['desktop_image_url'])): ?>
              <div class="desktop screen">
                <div class="screen-inner">
                  <img src="<?php echo $aPortfolio['slides'][0]['desktop_image_url']; ?>">
                </div>
              </div>
            <?php elseif(!empty($aPortfolio['slides'][0]['tablet_image_url'])): ?>
              <div class="tablet screen">
                <div class="screen-inner">
                  <img src="<?php echo $aPortfolio['slides'][0]['tablet_image_url']; ?>">
                </div>
              </div>
            <?php elseif(!empty($aPortfolio['slides'][0]['phone_image_url'])): ?>
              <div class="phone screen">
                <div class="screen-inner">
                  <img src="<?php echo $aPortfolio['slides'][0]['phone_image_url']; ?>">
                </div>
              </div>
            <?php endif; ?>
          <?php endif; ?>
          <h3><?php echo $aPortfolio['name']; ?></h3>
          <div class="description"><?php echo $aPortfolio['short_description']; ?></div>
          <ul class="menu-lite">
            <li><a href="/the-work/<?php echo $aPortfolio['tag']; ?>/">View project</a></li>
            <li><a href="/the-work/">View full portfolio</a></li>
          </ul>
          <ul class="service-icons text-hover">
            <?php foreach($aPortfolio['services'] as $aService) { ?>
            <li><span class="<?php echo $aService['tag']; ?> service-icon"><i></i></span><span class="hover"><?php echo $aService['name']; ?></span></li>
            <?php } ?>
          </ul>
        </div>
      </div><!-- /.half -->
    </div>
  </div><!-- /.home-portfolio -->
  <?php endif; ?>

  <div class="panel-wide home-marketing" data-panel-style="callout">
    <div class="row-flush">
      <div class="item-callout">
        <h3 data-text-align="center">Proven Web Experts Since 1998</h3>

        <p><em>Monkee-Boy has been helping clients of all shapes and sizes solve the web through a proven approach of:</em></p>

        <ul class="list-style-alt">
          <li>Creating research-based digital strategies that focus on both business and user goals.</li>
          <li>Designing beautiful and unique experiences that look great and get results.</li>
          <li>Developing pragmatic tools and functionality through WordPress and fully custom solutions.</li>
          <li>Growing businesses online through dedicated digital marketing and maintenance programs.</li>
        </ul>
      </div>

      <div class="item-panel">
        <div class="number" style="font-size: 180px;">
          <span class="arrow"></span><span class="value">116<span class="metric">%</span></span>
        </div>

        <h3>Increase in Organic Search Visits.</h3>
        <p>When tasked with promoting Texas history beyond the physical walls of the Bullock Texas State History Museum, Monkee-Boy delivered incredible results within the first 3 months.</p>

        <p class="dots" data-dots="dual"><a href="/the-work/bullock-texas-state-history-museum/" title="View Monkee-Boy's work for The Bullock Texas State History Museum.">View the Project</a></p>
      </div>
    </div>
  </div>

  <div class="panel-wide home-clients" data-panel-color="green" data-panel-style="slash">
    <div class="row section-head" data-text-align="right">
      <span class="section-title full dots" data-dots="left"><em>a few of our</em> successful clients</span>
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
      <span class="section-title full dots" data-dots="right"><em>the</em><br />jungle beat</span>
    </div>

    <div class="row-flush">
      <div class="one-third item-panel">
        <?php
        $oNews = $this->loadModel('news');
        $aArticles = $oNews->getLatest(2);
        ?>
        <h4>Latest News</h4>

        <div class="item-panel-inside" data-text-align="center">
          <!-- <figure><span class="home-news-icon"></span></figure> -->
          <?php foreach($aArticles as $aArticle) { ?>
            <time><?= date("m-d-Y", $aArticle['publish_on']) ?></time>
            <p><a href="<?= $aArticle['url'] ?>" title="<?= $aArticle['title'] ?>"><?= $aArticle['title'] ?> »</a></p>
          <?php } ?>

          <a href="/who/latest-news/" class="view-more">View All News</a>
        </div>
      </div>

      <div class="one-third item-panel alt">
        <h4>Sign Up For Our Newsletter</h4>

        <div class="item-panel-inside form-newsletter" data-text-align="center">
          <form action="/mailchimp-subscribe/" method="post">
            <div class="subscribe-status"></div> <!-- success -->
            <div class="subscribe-error hide">There has been an error subscribing to our newsletter. Please try again later.</div>

            <div class="form-fields">
              <label for="form-email">Enter your email</label>
              <input type="email" name="email" id="form-email">
              <input type="submit" value="Subscribe!">
            </div>
          </form>
        </div>
      </div>

      <div class="one-third item-panel twitter">
        <h4>On Twitter</h4>

        <div class="item-panel-inside">
          <?php
          $oTwitter = $this->loadTwitter();
          if($oTwitter !== false):
            $aStatuses = $oTwitter->get('statuses/user_timeline', array('count'=>1));
            $oStatus = array_shift($aStatuses); ?>
            <img src="<?= str_replace('_normal.png', '_bigger.png', $oStatus->user->profile_image_url_https) ?>" title="monkeeboy" class="profile_image">
            <div class="user">
              <div class="name"><?= $oStatus->user->name ?></div>
              <a href="<?= $oStatus->user->url ?>" title="@<?= $oStatus->user->screen_name ?>">@<?= $oStatus->user->screen_name ?></a>
            </div>
            <div class="text"><?= twitterlink($oStatus->text) ?></div>
            <div class="bottom">
              <time><a href="https://twitter.com/<?php echo $oStatus->user->screen_name; ?>/statuses/<?php echo $oStatus->id_str; ?>"><?php echo date("j M", strtotime($oStatus->created_at)); ?></a></time>
              <script type="text/javascript" async src="//platform.twitter.com/widgets.js"></script>
              <ul class="actions">
                <li>
                  <a href="https://twitter.com/intent/favorite?tweet_id=<?php echo $oStatus->id_str; ?>" class="favorite">Favorite</a>
                </li>
                <li>
                  <a href="https://twitter.com/intent/retweet?tweet_id=<?php echo $oStatus->id_str; ?>" class="retweet">Retweet</a>
                </li>
                <li>
                  <a href="https://twitter.com/intent/tweet?in_reply_to=<?php echo $oStatus->id_str; ?>" class="reply">Reply</a>
                </li>
                <li>
                  <a href="https://twitter.com/intent/follow?screen_name=<?php echo $oStatus->user->screen_name; ?>" class="follow">Follow</a>
                </li>
              </ul>
            </div>
          <?php else: ?>
            Failed...
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <?php $oBlog = $this->loadModel('posts'); ?>
  <div class="panel-wide home-blog" data-panel-color="light-grey">
    <div class="row section-head" data-text-align="center">
      <span class="section-title dots" data-dots="dual">the latest from the blog</span>
    </div>

    <div class="row-flush">
      <?php
      $aPosts = $oBlog->getPosts(null, false, false, null, null, 3);
      foreach($aPosts as $aPost): ?>
      <div class="one-third post-panel" data-text-align="center">
        <div class="post-panel-inside">
          <a href="<?= $aPost['url'] ?>" title="<?= $aPost['title'] ?>">
            <img src="<?= $aPost['listing_image_url'] ?>" alt="<?= $aPost['title'] ?>">
            <div class="post-title"><h5><?= $aPost['title'] ?></h5><span>Read now &raquo;</span></div>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

<?php $this->tplDisplay("inc_footer.php"); ?>
