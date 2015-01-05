<?php $this->tplDisplay("inc_header.php", ['menu'=>'home']); ?>

  <div class="row">
    <p class="subtitle hero-subtitle" data-text-align="center">Monkee-Boy is Full Service Web Design &amp; Digital Marketing Agency</p>
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
        <h3 data-text-align="center">16 Years of Growing with the Web</h3>

        <p><em>You don't need us to tell you that the web is always changing. What you do need is an experienced team you can trust that keeps up with that change and gets results by:</em></p>

        <ul class="list-style-alt">
          <li><a href="#" title="">Elevating identity with stunning creative assets &raquo;</a></li>
          <li><a href="#" title="">Increasing website traffic and brand awareness &raquo;</a></li>
          <li><a href="#" title="">Converting website visitors into loyal customers &raquo;</a></li>
          <li><a href="#" title="">Establishing leadership with valuable content &raquo;</a></li>
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
        $aArticle = $oNews->getLatest();
        ?>
        <h4>Latest News</h4>

        <div class="item-panel-inside" data-text-align="center">
          <figure><img src="/assets/news-icon.png" alt=""></figure>

          <p><a href="<?= $aArticle['url'] ?>" title="<?= $aArticle['title'] ?>"><?= $aArticle['title'] ?> »</a></p>
          <time><?= date("m-d", $aArticle['publish_on']) ?></time>
        </div>
      </div>

      <div class="one-third item-panel alt">
        <h4>Sign Up For Our Newsletter</h4>

        <div class="item-panel-inside form-newsletter" data-text-align="center">
          <form action="/mailchimp-subscribe/" method="post">
            <div class="subscribe-status"></div> <!-- success -->
            <div class="subscribe-error hide">There has been an error subscribing to our newsletter. Please try again later.</div>

            <label for="form-email">Enter your email</label>
            <input type="email" name="email" id="form-email">
            <input type="submit" value="Subscribe!">
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
            <img src="<?= str_replace('_normal.png', '_bigger.png', $oStatus->user->profile_image_url) ?>" title="monkeeboy" class="profile_image">
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
            <h4><?= $aPost['title'] ?><span>Read now &raquo;</span></h4>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

<?php $this->tplDisplay("inc_footer.php"); ?>
