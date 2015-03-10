<?php $this->tplDisplay("inc_header.php", ['menu'=>'troop', 'page_title'=>$aContent['title'], 'seo_title'=>$aContent['seo_title'], 'seo_description'=>$aContent['seo_description'], 'seo_keywords'=>$aContent['seo_keywords']]); ?>

  <div class="row page-title">
    <h1><?= $aContent['title'] ?></h1>
    <span class="subtitle"><?= $aContent['subtitle'] ?></span>
  </div>

  <ul class="row troop-list">
    <?php foreach($aTroop as $aEmployee): ?>
    <li>
      <a href="#" class="trigger">
        <img src="<?= $aEmployee['photo_url'] ?>" alt="" class="default-image">
        <img src="<?= $aEmployee['photo_over_url'] ?>" alt="" class="hover-image">
      </a>
      <div class="profile">
        <div class="profile-header">
          <div class="name">
            <?= $aEmployee['name'] ?>
            <span><?= $aEmployee['title'] ?></span>
          </div>
          <blockquote><?= $aEmployee['quote'] ?></blockquote>
        </div><!-- /.profile-header -->
        <div class="profile-content">
          <div class="half">
            <div class="profile-block">
              <span class="title">What</span>
              <p><?= $aEmployee['what'] ?></p>
            </div><!-- /.profile-block -->
            <div class="profile-block">
              <span class="title">Who</span>
              <p><?= $aEmployee['who'] ?></p>
            </div><!-- /.profile-block -->
          </div>
          <div class="half">
            <div class="profile-block">
              <span class="title">Where</span>
              <p><?= $aEmployee['where'] ?></p>
            </div><!-- /.profile-block -->
            <div class="profile-block">
              <span class="title">Quirk</span>
              <p><?= $aEmployee['quirk'] ?></p>
            </div><!-- /.profile-block -->
          </div>
        </div><!-- /.profile-content -->
        <div class="profile-footer">
          <p class="latest-update"></p>
          <ul class="social-links" role="menu">
            <?php if(!empty($aEmployee['social_accounts'])): ?>
              <?php foreach($aEmployee['social_accounts'] as $site=>$account): ?>
                <?php if(!empty($account)): ?>
                <li><a href="<?= $account ?>" class="<?= $site ?>"><?= ucwords($site) ?></a></li>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>
          </ul>
        </div>
      </div><!-- /.profile -->
    </li>
    <?php endforeach; ?>
  </ul>

  <aside class="troop-stats-pt1">
    <div class="row-flush section-head" data-text-align="center">
      <span class="subtitle">a little more about us for the curious.</span>
      <span class="section-title dots" data-dots="dual">troop stats</span>
    </div>
    <ul class="row-flush stats-list">
      <li class="mobile-os">
        <p><span class="number">2:1</span> <b>apple</b> vs <b>android</b></p>
      </li>
      <li class="bananas">
        <p><span class="number">77<span class="percent">%</span></span> of the troop<br><b>really like bananas</b></p>
      </li>
      <li class="tacos">
        <p><span class="number">2:1</span> <b>torchy's vs. tacodeli</b></p>
      </li>
    </ul>
    <div class="row-flush office-cat">
      <p><span class="number">67<span class="percent">%</span></span> in favor of an <b>office cat</b></p>
    </div>
  </aside>
  <aside class="troop-stats-pt2">
    <ul class="row-flush stats-list">
      <li class="code">
        <p><span class="number">6,000,000</span> <b>lines of code</b> lovingly handcrafted in a year</p>
      </li>
      <li class="desktop-os">
        <p><span class="number">60<span class="percent">%</span></span> <b>apple</b> vs. <b>40% pc</b></p>
      </li>
    </ul>
  </aside>

<?php $this->tplDisplay("inc_footer.php"); ?>
