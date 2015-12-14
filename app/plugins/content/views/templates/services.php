<!--
@Name: Services
@Description:
@Version: 1.0
@Restricted: false
@Author: Monkee-Boy
-->

<?php $this->tplDisplay("inc_header.php", ['menu'=>$aContent['tag'], 'page_title'=>$sTitle, 'seo_title'=>$aContent['seo_title'], 'seo_description'=>$aContent['seo_description'], 'seo_keywords'=>$aContent['seo_keywords']]); ?>

<div class="row page-title">
  <h1><?php echo $aContent['title'] ?></h1>
  <span class="subtitle"><?php echo $aContent['subtitle'] ?></span>
</div>

<div class="row">
  <div class="full">
    <object type="image/svg+xml" data="/images/service-subnav-svg.svg" id="services-menu-svg"></object>
    <script>
    var current_service_menu = '<?= $aContent['tag'] ?>';
    </script>

    <div class="services-menu-mobile">
      <div class="service-menu-icons">
        <ul class="services-row-1">
          <li><a href="/how-we-help/content-strategy/"><span class="contentstrategy service-icon<?php if($aContent['tag'] == 'content-strategy') { ?> active <?php } ?>"><i></i></span></a></li>
          <li><a href="/how-we-help/web-design-and-development/"><span class="webdesigndevelopment service-icon<?php if($aContent['tag'] == 'web-design-and-development') { ?> active <?php } ?>"><i></i></span></a></li>
          <li><a href="/how-we-help/analytics/"><span class="analytics service-icon<?php if($aContent['tag'] == 'analytics') { ?> active <?php } ?>"><i></i></span></a></li>
          <li><a href="/how-we-help/website-maintenance"><span class="maintenance service-icon<?php if($aContent['tag'] == 'website-maintenance') { ?> active <?php } ?>"><i></i></span></a></li>
        </ul>

        <ul class="services-row-2">
          <li><a href="/how-we-help/content-marketing/"><span class="contentmarketing service-icon<?php if($aContent['tag'] == 'content-marketing') { ?> active <?php } ?>"><i></i></span></a></li>
          <li><a href="/how-we-help/social-media/"><span class="socialmedia service-icon<?php if($aContent['tag'] == 'social-media') { ?> active <?php } ?>"><i></i></span></a></li>
          <li><a href="/how-we-help/seo/"><span class="seo service-icon<?php if($aContent['tag'] == 'seo') { ?> active <?php } ?>"><i></i></span></a></li>
          <li><a href="/how-we-help/pay-per-click/"><span class="ppc service-icon<?php if($aContent['tag'] == 'pay-per-click') { ?> active <?php } ?>"><i></i></span></a></li>
        </ul>
      </div>

      <div class="select-box select-box-service">
        <select name="select-service">
          <option value="">View All Services</option>

          <option value="/how-we-help/content-strategy/">Content Strategy</option>
          <option value="/how-we-help/web-design-and-development/">Web Design and Development</option>
          <option value="/how-we-help/analytics/">Analytics</option>
          <option value="/how-we-help/website-maintenance/">Website Maintenance</option>
          <option value="/how-we-help/content-marketing/">Content Marketing</option>
          <option value="/how-we-help/social-media/">Social Media</option>
          <option value="/how-we-help/seo/">SEO</option>
          <option value="/how-we-help/pay-per-click/">Pay-Per-Click</option>
        </select>
      </div>
      {footer}
      <script>
      $(function(){
        $('select[name=select-service]').change(function(){
          if($(this).val() != "") {
            location.href = $(this).val();
          }
        });
      });
      </script>
      {/footer}
    </div>
  </div>
</div>

<div class="row row-with-sidebar rtl">
  <div class="row-content content-block">
    <?= $aServiceContent['about']; ?>

    <?php if(!empty($aServiceContent['chart'] || !empty($aServiceContent['service_plans']))) { ?><a href="#jump" class="button">View Service Options</a><?php } ?>
  </div>

  <div class="row-sidebar">
    <div class="box-of-doom">
      <h4><?= $aServiceContent['benefits_title']; ?></h4>

      <ul class="list-style-alt">
        <?= $aServiceContent['benefits']; ?>
      </ul>
    </div>
  </div>
</div>

<?php if(!empty($aServiceContent['service_features'])) { ?>
<div class="row">
  <div class="plan-features">
    <?php if(!empty($aServiceContent['service_features']['title'])) { ?><h3><?= $aServiceContent['service_features']['title']; ?></h3><?php } ?>
    <div class="row-flush">
      <ul class="list-style-alt">
        <?= $aServiceContent['service_features']['features']; ?>
      </ul>
    </div>
  </div>
</div>
<?php } ?>

<div class="row row-with-sidebar">
  <div class="row-content content-block">
    <h3>What it means to be our client</h3>
    <?= $aServiceContent['being_a_client']; ?>

    <?php if(!empty($aServiceContent['clients'])) { ?>
      <ul class="featured-clients styleless" data-clients-style="services">
        <?php foreach($aServiceContent['clients'] as $client) { ?>
        <li>
          <a href="<?= $client['url']; ?>" title="<?= $client['name']; ?>"><img src="<?= $client['logo']; ?>" alt="<?= $client['name']; ?>"></a>
          <?php if(!empty($client['since'])) { ?><span>Client since <?= $client['since']; ?></span><?php } ?>
        </li>
        <?php } ?>
      </ul>
    <?php } ?>
  </div>

  <div class="row-sidebar">
    <div class="box-of-doom meet-the-team">
      <div class="meet-the-team-content">
        <h4>Working with our team</h4>
        <?= $aServiceContent['our_team']; ?>

        <a href="/who/the-troop/" class="button">Meet The Troop</a>
      </div>
    </div>
  </div>
</div>

<?php if(!empty($aServiceContent['case_study'])) { ?>
  <div class="row">
    <div class="full">
      <h3><?= $aServiceContent['case_study']['title']; ?> Case Study</h3>
    </div>

    <div class="case-studies">
      <div class="case-study">
        <h4>Challenge</h4>
        <div class="study-content">
          <ul class="list-style-alt">
            <?= $aServiceContent['case_study']['challenge']; ?>
          </ul>
        </div>
      </div>

      <div class="case-study">
        <h4>Solutions</h4>

        <div class="study-content">
          <ul class="list-style-alt">
            <?= $aServiceContent['case_study']['solutions']; ?>
          </ul>
        </div>
      </div>

      <div class="case-study">
        <h4>Results</h4>

        <div class="study-content">
          <div class="row-flush">
            <div class="half">
              <div class="study-result"><span><?= $aServiceContent['case_study']['results']['result']; ?></span></div>
            </div>

            <div class="half">
              <?= $aServiceContent['case_study']['results']['description']; ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="full center">
      <?php if(!empty($aServiceContent['case_study']['url'])) { ?><a href="<?= $aServiceContent['case_study']['url']; ?>"><?= $aServiceContent['case_study']['link_text']; ?></a><?php } ?>
    </div>
  </div>
<?php } ?>

<a name="jump" id="jump"></a>

<?php if(!empty($aServiceContent['chart'])) { ?>
  <div class="row">
    <div class="full">
      <div class="plans">
        <h2><?= $aServiceContent['chart']['title']; ?></h2>

        <div class="plan-section-description single-column">
          <p><?= $aServiceContent['chart']['intro']; ?></p>
        </div>

        <div class="plan-breakdown">
          <div class="row-flush top-row equal-height">
            <div class="plan-breakdown-col1">
              <span>Plan Includes</span>
            </div>

            <div class="plan-breakdown-col2">
              <span class="maintenance service-icon"><i></i></span>
              <div class="plan-title">
                <span><?= $aServiceContent['chart']['plans'][0]['title']; ?></span> - <sup>$</sup><?= $aServiceContent['chart']['plans'][0]['price']; ?>
              </div>

              <div class="plan-description">
                <?= $aServiceContent['chart']['plans'][0]['description']; ?>
              </div>
            </div>

            <div class="plan-breakdown-col3">
              <span class="maintenance service-icon"><i></i><span class="icon-seption-plus"></span></span>
              <div class="plan-title">
                <span><?= $aServiceContent['chart']['plans'][1]['title']; ?></span> - <sup>$</sup><?= $aServiceContent['chart']['plans'][1]['price']; ?>
              </div>

              <div class="plan-description">
                <?= $aServiceContent['chart']['plans'][1]['description']; ?>
              </div>
            </div>
          </div>

          <?php foreach($aServiceContent['chart']['plan_breakdown'] as $k => $plan_breakdown) { ?>
            <div class="row-flush equal-height">
              <div class="plan-breakdown-col1">
                <?= $plan_breakdown['name']; ?>
                <p class="service-description">
                  <?= $plan_breakdown['description']; ?>
                </p>
              </div>

              <div class="plan-breakdown-col2">
                <?php if($plan_breakdown['type'] === 'boolean') { ?>
                  <div class="plan-<?php if($aServiceContent['chart']['plans'][0]['features'][$k]) { echo 'checked'; } else { echo 'unchecked'; } ?>">&nbsp;</div>
                <?php } else { ?>
                  <div class="plan-text"><?= $aServiceContent['chart']['plans'][0]['features'][$k]; ?></div>
                <?php } ?>
              </div>

              <div class="plan-breakdown-col3">
                <?php if($plan_breakdown['type'] === 'boolean') { ?>
                  <div class="plan-<?php if($aServiceContent['chart']['plans'][1]['features'][$k]) { echo 'checked'; } else { echo 'unchecked'; } ?>">&nbsp;</div>
                <?php } else { ?>
                  <div class="plan-text"><?= $aServiceContent['chart']['plans'][1]['features'][$k]; ?></div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>

          <div class="row-flush last-row equal-height">
            <div class="plan-breakdown-col1">
              &nbsp;
            </div>

            <div class="plan-breakdown-col2">
              <a href="<?= $aServiceContent['chart']['plans'][0]['cta_url']; ?>" class="button button-alt"><?= $aServiceContent['chart']['plans'][0]['cta']; ?></a>
            </div>

            <div class="plan-breakdown-col3">
              <a href="<?= $aServiceContent['chart']['plans'][1]['cta_url']; ?>" class="button button-alt"><?= $aServiceContent['chart']['plans'][0]['cta']; ?></a>
            </div>
          </div>
        </div>

        <div class="plan-breakdown-mobile">
          <?php foreach($aServiceContent['chart']['plan_breakdown'] as $k => $plan_breakdown) { ?>
          <div class="plan-simple-breakdown">
            <div class="plan-breakdown-title">
              <?= $plan_breakdown['name']; ?>
              <p class="service-description">
                <?= $plan_breakdown['description']; ?>
              </p>
            </div>

            <div class="plan-breakdown-rows">
              <div class="plan-breakdown-row equal-height">
                <div class="plan-breakdown-col1">
                  <?= $aServiceContent['chart']['plans'][0]['title']; ?>
                </div>
                <div class="plan-breakdown-col2">
                  <?php if($plan_breakdown['type'] === 'boolean') { ?>
                    <div class="plan-<?php if($aServiceContent['chart']['plans'][0]['features'][$k]) { echo 'checked'; } else { echo 'unchecked'; } ?>">&nbsp;</div>
                  <?php } else { ?>
                    <div class="plan-text"><?= $aServiceContent['chart']['plans'][0]['features'][$k]; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="plan-breakdown-row equal-height">
                <div class="plan-breakdown-col1">
                  <?= $aServiceContent['chart']['plans'][1]['title']; ?>
                </div>
                <div class="plan-breakdown-col2">
                  <?php if($plan_breakdown['type'] === 'boolean') { ?>
                    <div class="plan-<?php if($aServiceContent['chart']['plans'][1]['features'][$k]) { echo 'checked'; } else { echo 'unchecked'; } ?>">&nbsp;</div>
                  <?php } else { ?>
                    <div class="plan-text"><?= $aServiceContent['chart']['plans'][1]['features'][$k]; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>

          <div class="plan-mobile-list-item">
            <span class="maintenance service-icon"><i></i></span>
            <div class="plan-title">
              <span><?= $aServiceContent['chart']['plans'][0]['title']; ?></span> - <sup>$</sup><?= $aServiceContent['chart']['plans'][0]['price']; ?>
            </div>

            <div class="plan-description">
              <?= $aServiceContent['chart']['plans'][0]['description']; ?>
            </div>

            <a href="<?= $aServiceContent['chart']['plans'][0]['cta_url']; ?>" class="button button-alt"><?= $aServiceContent['chart']['plans'][0]['cta']; ?></a>
          </div>

          <div class="plan-mobile-list-item">
            <span class="maintenance service-icon"><i></i></span>
            <div class="plan-title">
              <span><?= $aServiceContent['chart']['plans'][1]['title']; ?></span> - <sup>$</sup><?= $aServiceContent['chart']['plans'][1]['price']; ?>
            </div>

            <div class="plan-description">
              <?= $aServiceContent['chart']['plans'][1]['description']; ?>
            </div>

            <a href="<?= $aServiceContent['chart']['plans'][1]['cta_url']; ?>" class="button button-alt"><?= $aServiceContent['chart']['plans'][0]['cta']; ?></a>
          </div>
        </div>

        <div class="full center">
          <a href="<?= $aServiceContent['chart']['download']; ?>">Download a PDF With More Information About These Plans</a>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<?php if(!empty($aServiceContent['service_plans'])) { ?>
  <div class="row">
    <div class="full">
      <div class="plans">
        <h2>Service Options</h2>

        <div class="plans-side-by-side row-pop-flush">
          <div class="plan-side">
            <span class="<?= $aServiceContent['service_plans'][0]['icon']; ?> service-icon"><i></i></span>
            <h4><?= $aServiceContent['service_plans'][0]['title']; ?></h4>

            <?= $aServiceContent['service_plans'][0]['content']; ?>

            <a href="<?= $aServiceContent['service_plans'][0]['url']; ?>" class="button"><?= $aServiceContent['service_plans'][0]['button']; ?></a>
          </div>

          <div class="plan-side">
            <span class="<?= $aServiceContent['service_plans'][1]['icon']; ?> service-icon"><i></i><span class="icon-seption-plus"></span></span>
            <h4><?= $aServiceContent['service_plans'][1]['title']; ?></h4>

            <?= $aServiceContent['service_plans'][1]['content']; ?>

            <a href="<?= $aServiceContent['service_plans'][1]['url']; ?>" class="button"><?= $aServiceContent['service_plans'][1]['button']; ?></a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<?php if(!empty($aServiceContent['service_plan'])) { ?>
  <div class="row">
    <div class="full">
      <div class="plans">
        <div class="row-pop-flush">
          <div class="plans-single">
            <div class="plan-single-details">
              <span class="<?= $aServiceContent['service_plan']['icon']; ?> service-icon"><i></i><span class="icon-seption-star"></span></span>

              <h4><?= $aServiceContent['service_plan']['title']; ?></h4>

              <?= $aServiceContent['service_plan']['content']; ?>
            </div>

            <div class="plan-single-request">
              <a href="<?= $aServiceContent['service_plan']['url']; ?>" class="button"><?= $aServiceContent['service_plan']['button']; ?></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<?php
if(!empty($aServiceContent['cta'])) {
  $this->tplDisplay("inc_cta.php", array('line1' => $aServiceContent['cta']['content'], 'button' => $aServiceContent['cta']['button'], 'service' => $aServiceContent['cta']['service']));
}
?>

<!-- TODO: Add section thing -->

<?php $this->tplDisplay("inc_footer.php"); ?>
