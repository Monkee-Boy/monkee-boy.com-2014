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

$this->tplDisplay("inc_header.php", ['menu'=>'work-with-us', 'sPageTitle'=>$sTitle, 'seo_title'=>$aContent['seo_title'], 'seo_description'=>$aContent['seo_description'], 'seo_keywords'=>$aContent['seo_keywords']]); ?>

  <div class="row page-title">
    <h1><?php echo $sTitle; ?></h1>
    <p class="subtitle"><?php echo $sSubtitle; ?></p>
  </div>

  <form action="<?php echo $aContent['url'].'submit-form/' ?>" method="post" name="request-quote" class="request-quote-form" enctype="multipart/form-data">
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
          <span class="input-wrapper half"><input type="text" name="firstname" id="firtname" class="validate[required]" placeholder="Jane" value="<?= strip_tags($form_data['firstname']) ?>"></span>
          <span class="input-wrapper half"><input type="text" name="lastname" id="lastname" class="validate[required]" placeholder="Goodall" value="<?= strip_tags($form_data['lastname']) ?>"></span>
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
          <span class="input-wrapper"><input type="text" name="website" id="url" class="url validate[custom[url]]" value="<?= (!empty($form_data['website']))?strip_tags($form_data['website']):'http://' ?>"></span>
        </div>
      </div><!-- /.form-part1 -->
    </div>

    <div class="row full">
      <h2 class="form-title">Now tell us about your project</h2>
    </div>

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
          <input type="radio" id="brief2" name="brief" value="0" class="input-switch" data-switchto="brief-upload"<?php if(empty($form_data['brief'])){ echo ' checked'; } ?>>
          <span class="control-indicator"></span>
        </label>
      </div>
      <div class="right">
        <div id="no-brief" class="switch-target<?php if($form_data['brief'] === '1'){ echo ' active'; } ?>">
          <label for="project-desc" class="quiet">No RFP? No problem!</label>
          <p>What kind of project do you have and what are your goals?</p>
          <div class="input-wrapper"><textarea cols="10" rows="4" id="project-desc" name="project-desc"><?= $form_data['project-desc'] ?></textarea></div>
        </div>
        <div id="brief-upload" class="switch-target<?php if($form_data['brief'] !== '1'){ echo ' active'; } ?>">
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
    <div class="row">
      <div class="left">
        <h4>Have a project deadline?</h4>
        <label class="radio" for="date1">
          Nope. I'm flexible.
          <input type="radio" id="date1" name="deadline" value="0" class="input-switch" data-switchto="no-date"<?php if(empty($form_data['deadline'])){ echo ' checked'; } ?>>
          <span class="control-indicator"></span>
        </label>
        <label class="radio" for="date2">
          Yes, I have a specific date in mind.
          <input type="radio" id="date2" name="deadline" value="1" class="input-switch" data-switchto="datepicker"<?php if($form_data['deadline'] === '1'){ echo ' checked'; } ?>>
          <span class="control-indicator"></span>
        </label>
      </div>
      <div class="right">
        <div id="no-date" class="switch-target<?php if($form_data['deadline'] !== '1'){ echo ' active'; } ?>">
          <h5>Cool, we can work with you to plan the project schedule.</h5>
        </div>
        <div id="datepicker" class="switch-target<?php if($form_data['deadline'] === '1'){ echo ' active'; } ?>">
          <a href="#" class="datepicker">Pick a Date</a>
          <div class="date-input<?php if(!empty($form_data['deadline_date'])){ echo " selected"; } ?>">
            <input type="text" name="deadline_date" value="<?php if(!empty($form_data['deadline_date'])){ echo $form_data['deadline_date']; } else { echo "Select a Date"; } ?>">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="left">
        <label for="budget">Have a project budget?*</label>
        <p>Please select your desired project budget and we'll craft a solution just for you.</p>
      </div>
      <div class="right">
        <div class="select-box<?php if(!empty($form_data['budget'])){ echo " selected"; } ?>">
          <select name="budget" id="budget" class="validate[required]">
            <option value="">Select a Budget</option>
            <?php
            $aBudget = array(
              "$18,000-$30,000",
              "$31,000-$45,000",
              "$46,000-$60,000",
              "$61,000+"
            );
            foreach($aBudget as $option): ?>
            <option value="<?= $option ?>"<?php if($form_data['budget'] === $option){ echo ' selected="selected"'; } ?>><?= $option ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="full" data-text-align="center">
        <button type="submit" class="submit">Submit your request!</button>
      </div>
    </div>
  </form>

<?php $this->tplDisplay("inc_footer.php"); ?>
