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
      <h2 class="form-title">Tell Us a Little About Yourself</h2>
    </div>

    <div class="row">
      <div class="form-monkee">
        <div class="monkee"><div class="glasses-monkee"></div><div class="dark-monkee"></div></div>
      </div><!-- /form-monkee -->

      <div class="form-part1">
        <label for="name">Name*</label>
        <div class="form-step monkee-step">
          <span class="input-wrapper"><input type="text" name="name" id="name" class="validate[required]" value="<?= strip_tags($form_data['name']) ?>"></span>
        </div>

        <label for="email">Email*</label>
        <div class="form-step monkee-step">
          <span class="input-wrapper"><input type="email" name="email" id="email" class="email validate[required,custom[email]]" value="<?= strip_tags($form_data['email']) ?>"></span>
        </div>

        <label for="phone">Phone*</label>
        <div class="form-step monkee-step">
          <span class="input-wrapper"><input type="tel" name="phone" id="phone" class="validate[required,custom[phone],minSize[7],maxSize[14]]" value="<?= strip_tags($form_data['phone']) ?>"></span>
        </div>

        <label for="org">Organization*</label>
        <div class="form-step">
          <span class="input-wrapper"><input type="text" name="org" id="org" class="org validate[required]" value="<?= strip_tags($form_data['org']) ?>"></span>
        </div>

        <label for="url">Website URL*</label>
        <div class="form-step">
          <span class="input-wrapper"><input type="text" name="website" id="url" class="url validate[required]" value="<?= strip_tags($form_data['website']); ?>"></span>
        </div>

        <hr>

        <label for="form-additional_info">What kind of help are you looking for?*</label>
        <div class="form-step">
          <div class="input-wrapper"><textarea cols="10" rows="4" id="form-additional_info" name="additional_info" class="validate[required]"><?= $form_data['additional_info'] ?></textarea></div>
        </div>

        <div id="brief-upload" class="active">
          <label for="form-additionaldetails">Have additional details?</label>
          <div class="upload-box initial">
            <div class="uploaded-files"></div>
            <div class="drop-label">Drag &amp; drop file here <span>or</span></div>
            <a href="#" class="add-files">browse files!</a>
            <span class="file-size"><span>0</span> MB of 50 MB</span>
          </div>
        </div>

        <hr>

        <label for="budget">Budget*</label>
        <div class="form-step">
          <p style="margin-left: .83333em; margin-right: .83333em;">Our team can handle almost any size project. What budget range has been allocated to this project?</p>
          <span class="input-wrapper"><input type="text" name="budget" id="budget" class="validate[required]" value="<?= strip_tags($form_data['budget']); ?>"></span>
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
