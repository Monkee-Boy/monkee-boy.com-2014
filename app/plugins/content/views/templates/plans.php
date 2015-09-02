<!--
@Name: Plans
@Description: Showcase of all typography and content blocks.
@Version: 1.0
@Restricted: false
@Author: Monkee-Boy
-->

<?php $this->tplDisplay("inc_header.php", ['menu'=>$aContent['tag'], 'page_title'=>$aContent['title'], 'seo_title'=>$aContent['seo_title'], 'seo_description'=>$aContent['seo_description'], 'seo_keywords'=>$aContent['seo_keywords']]); ?>

  <div class="row page-title">
    <h1><?php echo $aContent['title'] ?></h1>
    <span class="subtitle"><?php echo $aContent['subtitle'] ?></span>
  </div>

  <?php
  $plans_subnav = array(
    'seo' => array(
      array('name' => 'SEO Foundation', 'url' => '/how-we-help/seo/seo-foundation/', 'menu' => 'seo-foundation'),
      array('name' => 'SEO Consulting', 'url' => '/how-we-help/seo/seo-consulting/', 'menu' => 'seo-consulting'),
      array('name' => 'SEO Complete', 'url' => '/how-we-help/seo/seo-complete/', 'menu' => 'seo-complete')
    ),
    'ppc' => array(
      array('name' => 'PPC Foundation', 'url' => '/how-we-help/pay-per-click/ppc-foundation/', 'menu' => 'ppc-foundation'),
      array('name' => 'PPC Advanced', 'url' => '/how-we-help/pay-per-click/ppc-advanced/', 'menu' => 'ppc-advanced'),
      array('name' => 'PPC Complete', 'url' => '/how-we-help/pay-per-click/ppc-complete/', 'menu' => 'ppc-complete')
    ),
    'socialmedia' => array(
      array('name' => 'Social Media Foundation', 'url' => '/how-we-help/social-media/social-media-foundation/', 'menu' => 'social-media-foundation'),
      array('name' => 'Social Media Consulting', 'url' => '/how-we-help/social-media/social-media-consulting/', 'menu' => 'social-media-consulting'),
      array('name' => 'Social Media Complete', 'url' => '/how-we-help/social-media/social-media-complete/', 'menu' => 'social-media-complete')
    )
  );
  ?>

  <div class="row sub-nav">
    <div class="full">
      <ul class="dropdown-extended">
        <?php foreach($plans_subnav[$aPlanContent['subnav']] as $subnav) { ?>
          <li><a href="<?= $subnav['url']; ?>"<?php if($aContent['tag'] === $subnav['menu']): ?> class="current"<?php endif; ?>><?= $subnav['name']; ?></a></li>
        <?php } ?>
      </ul>

      <div class="select-box select-box-subnav">
        <select name="select-subnav" id="select-subnav">
          <option value="">View Plans</option>

          <?php foreach($plans_subnav[$aPlanContent['subnav']] as $subnav) { ?>
            <option value="<?= $subnav['url']; ?>"<?php if($aContent['tag'] === $subnav['menu']): ?> selected<?php endif; ?>><?= $subnav['name']; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
  </div>

  {footer}
  <script>
  $(function(){
    $('select[name=select-subnav]').change(function(){
      if($(this).val() != "") {
        location.href = $(this).val();
      }
    });
  });
  </script>
  {/footer}

  <div class="row">
    <div class="single-column content-block">
      <?php echo $aContent['content'] ?>
    </div>
  </div>

  <?php if(!empty($aPlanContent['features']['content'])) { ?>
    <div class="row">
      <div class="plan-features">
        <h3><?= $aPlanContent['features']['title']; ?></h3>
        <div class="row-flush">
          <ul class="list-style-alt">
            <?= $aPlanContent['features']['content']; ?>
          </ul>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if(!empty($aPlanContent['team']['content'])) { ?>
    <div class="row">
      <div class="box-of-doom meet-the-team full-width">
        <div class="meet-the-team-content">
          <h3>Who is on my monkee-boy team?</h3>
          <?= $aPlanContent['team']['content']; ?>

          <?php if(!empty($aPlanContent['team']['members'])) { ?>
            <ul class="team-list">
              <?= $aPlanContent['team']['members']; ?>
            </ul>
          <?php } ?>
        </div>
      </div>
    </div>
  <?php } ?>

  <div class="row">
    <div class="full no-gutter-later">
      <div class="plans">
        <div class="plan-row">
          <?php echo $aContent['title'] ?> <?php if(!empty($aPlanContent['price'])) { ?>Cost: <span><sup>$</sup><?= $aPlanContent['price']; ?><sup class="cents">00</sup></span><?php } ?>
        </div>

        <?php if(!empty($aPlanContent['cta'])) { ?>
          <div class="plan-row">
            <div class="row-flush">
              <div class="plan-row-left">
                <h4><?= $aPlanContent['cta']['title']; ?></h4>
                <?= $aPlanContent['cta']['content']; ?>
              </div>

              <div class="plan-row-right">
                <a href="<?= $aPlanContent['cta']['url']; ?>" class="button"><?= $aPlanContent['cta']['button']; ?></a>
              </div>
            </div>
          </div>
        <?php } ?>

        <?php if(!empty($aPlanContent['production_schedule'])) { ?>
          <div class="plan-row">
            <h4><?= $aPlanContent['production_schedule']['title']; ?></h4>
            <?= $aPlanContent['production_schedule']['content']; ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

  <?php if(!empty($aPlanContent['other_plans'])) { ?>
    <div class="row">
      <div class="plan-cta">
        <h2><?= $aPlanContent['other_plans']['title']; ?></h2>
        <p><?= $aPlanContent['other_plans']['description']; ?></p>

        <ul class="list-style-alt">
          <?php foreach($aPlanContent['other_plans']['plans'] as $plan) { ?>
            <li><a href="<?= $plan['link']; ?>"><strong><?= $plan['title']; ?></strong></a>: <?= $plan['description']; ?></li>
          <?php } ?>
        </ul>
      </div>
    </div>
  <?php } ?>

<?php $this->tplDisplay("inc_footer.php"); ?>
