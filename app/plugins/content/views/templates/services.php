<!--
@Name: Services
@Description: Showcase of all typography and content blocks.
@Version: 1.0
@Restricted: false
@Author: Monkee-Boy
-->

<?php $this->tplDisplay("inc_header.php", ['menu'=>'home']); ?>

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
          <li><a href="#"><span class="strategy service-icon"><i></i></span></a></li>
          <li><a href="#"><span class="design service-icon"><i></i></span></a></li>
          <li><a href="#"><span class="development service-icon"><i></i></span></a></li>
          <li><a href="#"><span class="marketing service-icon"><i></i></span></a></li>
        </ul>
        <ul class="services-row-2">
          <li><a href="#"><span class="strategy service-icon"><i></i></span></a></li>
          <li><a href="#"><span class="design service-icon active"><i></i></span></a></li>
          <li><a href="#"><span class="development service-icon"><i></i></span></a></li>
          <li><a href="#"><span class="marketing service-icon"><i></i></span></a></li>
        </ul>
      </div>
      <div class="select-box select-box-service">
        <select name="select-service">
          <option value="">View All Services</option>

          <option value="">Strategy</option>
          <option value="">Lorem Ipsum</option>
          <option value="">Delor sit amet</option>
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
  <div class="row-content">
    <?= $aServiceContent['about']; ?>
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

<div class="row row-with-sidebar">
  <div class="row-content">
    <h3>What it means to be our client</h3>
    <?= $aServiceContent['being_a_client']; ?>

    <ul class="featured-clients styleless" data-clients-style="services">
      <li>
        <a href="/client-list/" title="Dell Children's"><img src="/uploads/clients/svg_20.svg" alt="Dell Children's"></a>
        <span>Client since 2006</span>
      </li>
      <li>
        <a href="/client-list/" title="ABC Home and Commercial Services"><img src="/uploads/clients/svg_4.svg" alt="ABC Home and Commercial Services"></a>
        <span>Client since 1081</span>
      </li>
    </ul>
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

<div class="row">
  <div class="full">
    <h3>Austin Chamber Case Study</h3>
  </div>

  <div class="case-studies">
    <div class="case-study">
      <h4>Challenge</h4>
      <div class="study-content">
        <ul class="list-style-alt">
          <li>Putant saperet mediocritatem id cum. Graeco contentiones ei has, sed ex quod inciderint.</li>
          <li>Vim graece vocibus id, in minimum electram pri, mandamus torquatos voluptatum te ius.</li>
        </ul>
      </div>
    </div>

    <div class="case-study">
      <h4>Solutions</h4>

      <div class="study-content">
        <ul class="list-style-alt">
          <li>Putant saperet mediocritatem id cum. Graeco contentiones ei has, sed ex quod inciderint.</li>
          <li>Vim graece vocibus id, in minimum electram pri, mandamus torquatos voluptatum te ius.</li>
        </ul>
      </div>
    </div>

    <div class="case-study">
      <h4>Results</h4>

      <div class="study-content">
        <div class="row-flush">
          <div class="half">
            <div class="study-result"><span>90%</span></div>
          </div>

          <div class="half">
            <p>Putant saperet mediocritatem id cum. Graeco contentiones ei has, sed ex quod inciderint.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="full center">
    <a href="#">View Full Case Study</a>
  </div>
</div>

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
        <a href="#">Download a PDF of these comparisons</a>
      </div>
    </div>
    <!-- TODO: Add mobile version -->
  </div>
</div>

<div class="row">
  <div class="full">
    <div class="plans">
      <h2>Service Plans</h2>
      <div class="plans-side-by-side row-pop-flush">
        <div class="plan-side">
          <span class="development service-icon"><i></i></span>
          <h4>Social Media Basic</h4>
          <p>Putant saperet mediocritatem id cum. Graeco contentiones ei has, sed ex quod inciderint.</p>
          <p>Great for: <strong>Startups</strong></p>
          <a href="#" class="button">View Plan</a>
        </div>
        <div class="plan-side">
          <span class="development service-icon"><i></i><span class="icon-seption-plus"></span></span>
          <h4>Social Media Basic</h4>
          <p>Putant saperet mediocritatem id cum. Graeco contentiones ei has, sed ex quod inciderint.</p>
          <p>Great for: <strong>Startups</strong></p>
          <a href="#" class="button">View Plan</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="full">
    <div class="plans">
      <div class="row-pop-flush">
        <div class="plans-single">
          <div class="plan-single-details">
            <span class="development service-icon"><i></i><span class="icon-seption-star"></span></span>

            <h4>Social Media Basic</h4>
            <p>Putant saperet mediocritatem id cum. Graeco contentiones ei has, sed ex quod inciderint.</p>
            <p>Great for: <strong>Startups</strong></p>
          </div>

          <div class="plan-single-request">
            <a href="#" class="button">Request Service</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- TODO: Add CTA -->

<!-- TODO: Add section thing -->

<?php $this->tplDisplay("inc_footer.php"); ?>
