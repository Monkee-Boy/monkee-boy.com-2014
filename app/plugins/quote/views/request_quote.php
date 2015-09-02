<!--
@Name: Request Quote Form
@Description: Content template that includes the form for requesting a quote.
@Version: 1.0
@Restricted: true
@Author: Monkee-Boy
-->

<?php
if(!empty($aContent)) {
  $sTitle = $aContent['title'];
  $sSubtitle = $aContent['subtitle'];
} else {
  // $sTitle = "Work With Us";
  // $sSubtitle = "Let's start a dialogue. Just fill out the form below.";
}

$this->tplDisplay("inc_header.php", ['menu'=>'request-a-quote', 'sPageTitle'=>$sTitle, 'seo_title'=>$aContent['seo_title'], 'seo_description'=>$aContent['seo_description'], 'seo_keywords'=>$aContent['seo_keywords']]); ?>

  <div class="row page-title">
    <h1><?php echo $sTitle; ?></h1>
    <p class="subtitle"><?php echo $sSubtitle; ?></p>
  </div>

  <?php $this->tplDisplay('inc_subnav.php', array('menu' => 'request-a-quote', 'nav' => 'contact')); ?>

  <form action="<?php echo $aContent['url'].'submit-form/' ?>" method="post" name="request-quote" class="request-quote-form" enctype="multipart/form-data">
    <div class="row full">
      <h2 class="form-title">Tell us about your project</h2>
    </div>

    <div class="row">
      <div class="left">
        <label for="main-service">What Primary Service Do You Need?</label>
        <p>Let us know how Monkee-Boy can help you solve the web.</p>
      </div>

      <div class="right sub-nav">
        <ul class="nav-block">
          <li><a href="#" class="form-selectService<?php if($_GET['service'] == 'content-strategy') { ?> current<?php } ?>" data-service-options="">Content Strategy</a></li>
          <li><a href="#" class="form-selectService<?php if($_GET['service'] == 'web-design-development') { ?> current<?php } ?>" data-service-options="design-development">Web Design and Development</a></li>
          <li><a href="#" class="form-selectService<?php if($_GET['service'] == 'analytics') { ?> current<?php } ?>" data-service-options="">Analytics</a></li>
          <li><a href="#" class="form-selectService<?php if($_GET['service'] == 'website-maintenance') { ?> current<?php } ?>" data-service-options="website-maintenance">Website Maintenance</a></li>
          <li><a href="#" class="form-selectService<?php if($_GET['service'] == 'content-marketing') { ?> current<?php } ?>" data-service-options="">Content Marketing</a></li>
          <li><a href="#" class="form-selectService<?php if($_GET['service'] == 'social-media') { ?> current<?php } ?>" data-service-options="social-media">Social Media</a></li>
          <li><a href="#" class="form-selectService<?php if($_GET['service'] == 'seo') { ?> current<?php } ?>" data-service-options="seo">SEO</a></li>
          <li><a href="#" class="form-selectService<?php if($_GET['service'] == 'ppc') { ?> current<?php } ?>" data-service-options="pay-per-click">Pay-Per-Click</a></li>
        </ul>
      </div>

      <input type="hidden" name="main-service" id="main-service" value="<?php if($_GET['service'] == 'content-strategy') { echo 'Content Strategy'; } elseif($_GET['service'] == 'web-design-development') { echo 'Web Design and Development'; } elseif($_GET['service'] == 'analytics') { echo 'Analytics'; } elseif($_GET['service'] == 'website-maintenance') { echo 'Website Maintenance'; } elseif($_GET['service'] == 'content-marketing') { echo 'Content Marketing'; } elseif($_GET['service'] == 'social-media') { echo 'Social Media'; } elseif($_GET['service'] == 'seo') { echo 'SEO'; } elseif($_GET['service'] == 'ppc') { echo 'Pay-Per-Click'; } ?>">
    </div>
    <hr>
    {footer}
    <script>
    $('.form-selectService').on('click', function(event) {
      event.preventDefault();
      var service = $(this);
      var serviceOption = service.data('service-options');

      $('.form-selectService.current').removeClass('current');
      service.addClass('current');
      $('#main-service').val(service.text()); // Set input value to selected service.

      if(serviceOption === 'design-development') {
        $('.service-option').slideUp(300);
        $('.js-DesignDevBlock').slideDown('slow');
      } else {
        $('.service-option').slideUp(300);
        $('.js-DesignDevBlock').slideUp(300);
        if(serviceOption !== '') {
          $('#'+serviceOption).delay(500).slideDown('slow');
        }
      }
    });
    </script>
    {/footer}

    <div class="service-option<?php if($_GET['service'] != 'website-maintenance') { ?> hide<?php } ?>" id="website-maintenance">
      <div class="row">
        <div class="left">
          <label for="service-option">Which Option Fits Your Needs?</label>
        </div>

        <div class="right sub-nav">
          <ul class="nav-block alt">
            <li><a href="#" class="form-selectServiceOption<?php if($_GET['option'] == 'basic') { ?> current<?php } ?>" data-service-option="Website Maintenance Basic"><span class="maintenance service-icon"><i></i></span> Website Maintenance Basic</a></li>
            <li><a href="#" class="form-selectServiceOption<?php if($_GET['option'] == 'plus') { ?> current<?php } ?>" data-service-option="Website Maintenance Plus"><span class="maintenance service-icon"><i></i><span class="icon-seption-plus"></span></span> Website Maintenance Plus</a></li>
            <li><a href="#" class="form-selectServiceOption" data-service-option="Not sure what package"><span class="unsure service-icon"><i></i></span> Not sure what package</a></li>
          </ul>
        </div>
      </div>
      <hr>
    </div>

    <div class="service-option<?php if($_GET['service'] != 'social-media') { ?> hide<?php } ?>" id="social-media">
      <div class="row">
        <div class="left">
          <label for="service-option">Which Option Fits Your Needs?</label>
        </div>

        <div class="right sub-nav">
          <ul class="nav-block alt">
            <li><a href="#" class="form-selectServiceOption<?php if($_GET['option'] == 'social-media-foundation') { ?> current<?php } ?>" data-service-option="Social Media Foundation"><span class="socialmedia service-icon"><i></i></span> Social Media Foundation</a></li>
            <li><a href="#" class="form-selectServiceOption<?php if($_GET['option'] == 'social-media-consulting') { ?> current<?php } ?>" data-service-option="Social Media Consulting"><span class="socialmedia service-icon"><i></i><span class="icon-seption-plus"></span></span> Social Media Consulting</a></li>
            <li><a href="#" class="form-selectServiceOption<?php if($_GET['option'] == 'social-media-complete') { ?> current<?php } ?>" data-service-option="Social Media Complete"><span class="socialmedia service-icon"><i></i><span class="icon-seption-star"></span></span> Social Media Complete</a></li>
            <li><a href="#" class="form-selectServiceOption" data-service-option="Not sure what package"><span class="unsure service-icon"><i></i></span> Not sure what package</a></li>
          </ul>
        </div>
      </div>
      <hr>
    </div>

    <div class="service-option<?php if($_GET['service'] != 'seo') { ?> hide<?php } ?>" id="seo">
      <div class="row">
        <div class="left">
          <label for="service-option">Which Option Fits Your Needs?</label>
        </div>

        <div class="right sub-nav">
          <ul class="nav-block alt">
            <li><a href="#" class="form-selectServiceOption<?php if($_GET['option'] == 'seo-foundation') { ?> current<?php } ?>" data-service-option="SEO Foundation"><span class="seo service-icon"><i></i></span> SEO Foundation</a></li>
            <li><a href="#" class="form-selectServiceOption<?php if($_GET['option'] == 'seo-consulting') { ?> current<?php } ?>" data-service-option="SEO Consulting"><span class="seo service-icon"><i></i><span class="icon-seption-plus"></span></span> SEO Consulting</a></li>
            <li><a href="#" class="form-selectServiceOption<?php if($_GET['option'] == 'seo-complete') { ?> current<?php } ?>" data-service-option="SEO Complete"><span class="seo service-icon"><i></i><span class="icon-seption-star"></span></span> SEO Complete</a></li>
            <li><a href="#" class="form-selectServiceOption" data-service-option="Not sure what package"><span class="unsure service-icon"><i></i></span> Not sure what package</a></li>
          </ul>
        </div>
      </div>
      <hr>
    </div>

    <div class="service-option<?php if($_GET['service'] != 'ppc') { ?> hide<?php } ?>" id="pay-per-click">
      <div class="row">
        <div class="left">
          <label for="service-option">Which Option Fits Your Needs?</label>
        </div>

        <div class="right sub-nav">
          <ul class="nav-block alt">
            <li><a href="#" class="form-selectServiceOption<?php if($_GET['option'] == 'ppc-foundation') { ?> current<?php } ?>" data-service-option="PPC Foundation"><span class="ppc service-icon"><i></i></span> PPC Foundation</a></li>
            <li><a href="#" class="form-selectServiceOption<?php if($_GET['option'] == 'ppc-advanced') { ?> current<?php } ?>" data-service-option="PPC Advanced"><span class="ppc service-icon"><i></i><span class="icon-seption-plus"></span></span> PPC Advanced</a></li>
            <li><a href="#" class="form-selectServiceOption<?php if($_GET['option'] == 'ppc-complete') { ?> current<?php } ?>" data-service-option="PPC Complete"><span class="ppc service-icon"><i></i><span class="icon-seption-star"></span></span> PPC Complete</a></li>
            <li><a href="#" class="form-selectServiceOption" data-service-option="Not sure what package"><span class="unsure service-icon"><i></i></span> Not sure what package</a></li>
          </ul>
        </div>
      </div>
      <hr>
    </div>

    <input type="hidden" name="main-serviceoption" id="main-serviceoption" value="<?php if($_GET['option'] == 'basic') { echo 'Website Maintenance Basic'; } elseif($_GET['option'] == 'plus') { echo 'Website Maintenance Plus'; } elseif($_GET['option'] == 'social-media-foundation') { echo 'Social Media Foundation'; } elseif($_GET['option'] == 'social-media-consulting') { echo 'Social Media Consulting'; } elseif($_GET['option'] == 'social-media-complete') { echo 'Social Media Complete'; } elseif($_GET['option'] == 'seo-foundation') { echo 'SEO Foundation'; } elseif($_GET['option'] == 'seo-consulting') { echo 'SEO Consulting'; } elseif($_GET['option'] == 'seo-complete') { echo 'SEO Complete'; } elseif($_GET['option'] == 'ppc-foundation') { echo 'PPC Foundation'; } elseif($_GET['option'] == 'ppc-advanced') { echo 'PPC Advanced'; } elseif($_GET['option'] == 'ppc-complete') { echo 'PPC Complete'; } ?>">

    {footer}
    <script>
    $('.form-selectServiceOption').on('click', function(event) {
      event.preventDefault();
      var serviceOption = $(this);

      $('.form-selectServiceOption.current').removeClass('current');
      serviceOption.addClass('current');
      $('#main-serviceoption').val(serviceOption.data('service-option')); // Set input value to selected service option.
    });
    </script>
    {/footer}

    <div class="js-DesignDevBlock hide">
      <div class="row">
        <div class="left">
          <h4>Do you have a Request for Proposal (RFP)?</h4>
          <label class="radio" for="brief1">
            Not yet, but I can tell you about my project.
            <input type="radio" id="brief1" name="brief" value="1" class="input-switch" data-switchto="no-brief"<?php if($form_data['brief'] === '1'){ echo ' checked'; } ?>>
            <span class="control-indicator"></span>
          </label>
          <label class="radio" for="brief2">
            Yes, I do.
            <input type="radio" id="brief2" name="brief" value="0" class="input-switch" data-switchto="brief-upload"<?php if($form_data['brief'] === '0'){ echo ' checked'; } ?>>
            <span class="control-indicator"></span>
          </label>
        </div>

        <div class="right">
          <div id="no-brief" class="switch-target<?php if($form_data['brief'] === '1'){ echo ' active'; } ?>">
            <label for="project-desc" class="quiet">No RFP? No problem!</label>
            <p>Please tell us know a little about your project. What are your goals? What do you hope to accomplish? What specific challenges have gotten in your way? What is/isn't working? Any advanced functionality or tools you need? Etc...</p>
            <div class="input-wrapper"><textarea cols="10" rows="4" id="project-desc" name="project-desc"><?= $form_data['project-desc'] ?></textarea></div>
          </div>

          <div id="brief-upload" class="switch-target<?php if($form_data['brief'] === '0'){ echo ' active'; } ?>">
            <h5>Great! Upload it here:</h5>
            <div class="upload-box initial">
              <div class="uploaded-files"></div>
              <div class="drop-label">Drag &amp; drop files here <span>or</span></div>
              <a href="#" class="add-files">browse files!</a>
              <span class="file-size"><span>0</span> MB of 50 MB</span>
            </div>
          </div>
        </div>
      </div>
      <hr>

      <div class="row">
        <div class="left">
          <h4>Have a project deadline?</h4>
          <label class="radio" for="date1">
            Nope. I'm flexible.
            <input type="radio" id="date1" name="deadline" value="0" class="input-switch" data-switchto="no-date"<?php if($form_data['deadline'] === '1'){ echo ' checked'; } ?>>
            <span class="control-indicator"></span>
          </label>

          <label class="radio" for="date2">
            Yes, I have a specific date in mind.
            <input type="radio" id="date2" name="deadline" value="1" class="input-switch" data-switchto="deadlinedate"<?php if($form_data['deadline'] === '1'){ echo ' checked'; } ?>>
            <span class="control-indicator"></span>
          </label>
        </div>

        <div class="right">
          <div id="no-date" class="switch-target<?php if($form_data['deadline'] === '1'){ echo ' active'; } ?>">
            <h5>Cool, we can work with you to plan the project schedule.</h5>
          </div>

          <div id="deadlinedate" class="switch-target select-box<?php if(!empty($form_data['deadline'])){ echo " selected"; } ?>">
            <select name="deadline_date" id="deadline_date">
              <option value="">Select a Date</option>
              <?php
              $aDeadlineDate = array(
                "2015-Q3",
                "2015-Q4",
                "2016-Q1",
                "2016-Q2",
                "2016-Q3",
                "2016-Q4",
                "2017",
                "2018"
              );
              foreach($aDeadlineDate as $option): ?>
              <option value="<?= $option ?>"<?php if($form_data['deadline_date'] === $option){ echo ' selected="selected"'; } ?>><?= $option ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>
      <hr>

      <div class="row">
        <div class="left">
          <label for="budget">Have a project budget?*</label>
          <p>Please select your desired project budget and we'll craft a solution just for you.</p>
        </div>

        <div class="right">
          <div class="select-box<?php if(!empty($form_data['budget'])){ echo " selected"; } ?>">
            <select name="budget" id="budget">
              <option value="">Select a Budget</option>
              <?php
              $aBudget = array(
                "under $25,000",
                "$25,000-50,000",
                "$50,000-75,000",
                "$75,000-100,000",
                "$100,000+"
              );
              foreach($aBudget as $option): ?>
              <option value="<?= $option ?>"<?php if($form_data['budget'] === $option){ echo ' selected="selected"'; } ?>><?= $option ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>
      <hr>
    </div> <!-- /.js-DesignDevBlock -->

    <div class="row">
      <div class="left">
        <label for="additional-services">Need any additional services?</label>
        <p>Please list any other services that are essential to your success on the web (ex: a website design might also need SEO).</p>
      </div>

      <div class="right">
        <div class="input-wrapper"><textarea cols="10" rows="4" id="additional-services" name="additional-services"><?= $form_data['additional-services'] ?></textarea></div>
      </div>
    </div>
    <hr>

    <div class="row">
      <div class="left">
        <label for="additional-info">Anything else we should know?</label>
      </div>

      <div class="right">
        <div class="input-wrapper"><textarea cols="10" rows="4" id="additional-info" name="additional-info"><?= $form_data['additional-info'] ?></textarea></div>
      </div>
    </div>

    <div class="row full">
      <h2 class="form-title">Tell Us a Little About Yourself</h2>
    </div>

    <div class="row">
      <div class="form-monkee">
        <div class="monkee"><div class="glasses-monkee"></div><div class="dark-monkee"></div></div>
      </div><!-- /form-monkee -->

      <div class="form-part1">
        <label for="firstname">Name*</label>
        <div class="form-step monkee-step">
          <span class="input-wrapper half"><input type="text" name="firstname" id="firtname" class="validate[required]" placeholder="First" value="<?= strip_tags($form_data['firstname']) ?>"></span>
          <span class="input-wrapper half"><input type="text" name="lastname" id="lastname" class="validate[required]" placeholder="Last" value="<?= strip_tags($form_data['lastname']) ?>"></span>
        </div>
        <label for="email">Email*</label>
        <div class="form-step monkee-step">
          <span class="input-wrapper"><input type="email" name="email" id="email" class="email validate[required,custom[email]]" value="<?= strip_tags($form_data['email']) ?>"></span>
        </div>
        <label for="phone">Phone*</label>
        <div class="form-step monkee-step">
          <span class="input-wrapper phone"><input type="tel" name="phone" id="phone" class="validate[required,custom[phone],minSize[7],maxSize[14]]" value="<?= strip_tags($form_data['phone']) ?>"></span>
        </div>
        <label for="org">Organization</label>
        <div class="form-step">
          <span class="input-wrapper"><input type="text" name="org" id="org" class="org" value="<?= strip_tags($form_data['org']) ?>"></span>
        </div>
        <label for="url">Website URL</label>
        <div class="form-step">
          <span class="input-wrapper"><input type="text" name="website" id="url" class="url" value="<?= (!empty($form_data['website']))?strip_tags($form_data['website']):'http://' ?>"></span>
        </div>
      </div><!-- /.form-part1 -->
    </div>

    <div class="row">
      <div class="full" data-text-align="center">
        <button type="submit" class="submit">Submit your request!</button>
      </div>
    </div>
  </form>

<?php $this->tplDisplay("inc_footer.php"); ?>
