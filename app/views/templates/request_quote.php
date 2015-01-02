<!--
@Name: Request Quote Form
@Description: Content template that includes the form for requesting a quote.
@Version: 1.0
@Restricted: true
@Author: Monkee-Boy
-->

<?php $aContent = getContent(null, "work-with-us");
if(!empty($aContent)) {
  $sTitle = $aContent['title'];
  $sSubtitle = $aContent['subtitle'];
} else {
  $sTitle = "Work With Us";
  $sSubtitle = "Let's start a dialogue. Just fill out the form below.";
}

$this->tplDisplay("inc_header.php", ['menu'=>'home', 'sPageTitle'=>$sTitle]); ?>

  <div class="row full">
    <div class="page-title">
      <h1><?php echo $sTitle; ?></h1>
      <p class="subtitle"><?php echo $sSubtitle; ?></p>
    </div>
  </div>

  <form action="#" name="request-quote" class="request-quote-form">
    <div class="row full">
      <h2 class="form-title">Please tell us a lil&rsquo; about yourself</h2>
    </div>

    <div class="row">
      <div class="form-monkee">
        <div class="monkee"><div class="glasses-monkee"></div><div class="dark-monkee"></div></div>
      </div><!-- /form-monkee -->

      <div class="form-part1">
        <label for="firstname">Name*</label>
        <div class="form-step monkee-step">
          <span class="input-wrapper half"><input type="text" id="firtname" class="validate[required]" placeholder="Jane"></span>
          <span class="input-wrapper half"><input type="text" id="lastname" class="validate[required]" placeholder="Goodall"></span>
        </div>
        <label for="email">Email*</label>
        <div class="form-step monkee-step">
          <span class="input-wrapper"><input type="email" class="email validate[required,custom[email]]" id="email"></span>
        </div>
        <label for="phone">Phone*</label>
        <div class="form-step monkee-step">
          <span class="input-wrapper phone"><input type="tel" class="validate[required,custom[phone],minSize[7],maxSize[14]]" id="phone"></span>
        </div>
        <label for="org">Organization</label>
        <div class="form-step">
          <span class="input-wrapper"><input type="text" class="org" id="org"></span>
        </div>
        <label for="url">Website URL</label>
        <div class="form-step">
          <span class="input-wrapper"><input type="text" class="url validate[custom[url]]" value="http://" id="url"></span>
        </div>
      </div><!-- /.form-part1 -->
    </div>

    <div class="row full">
      <h2 class="form-title">Now tell us about your project</h2>
    </div>

    <div class="row">
      <div class="left">
        <h4>Have a project brief?</h4>
        <label class="radio" for="brief1">
          Not yet but I can tell you about it.
          <input type="radio" id="brief1" name="brief" class="input-switch" data-switchto="no-brief">
          <span class="control-indicator"></span>
        </label>
        <label class="radio" for="brief2">
          Yes I sure do!
          <input type="radio" id="brief2" name="brief" class="input-switch" data-switchto="brief-upload" checked>
          <span class="control-indicator"></span>
        </label>
      </div>
      <div class="right">
        <div id="no-brief" class="switch-target">
          <label for="project-desc">No brief, no problem</label>
          <p>Please tell us about your project. What are your current challenges? What are you looking to accomplish?</p>
          <div class="input-wrapper"><textarea cols="10" rows="4" id="project-desc" name="project-desc"></textarea></div>
        </div>
        <div id="brief-upload" class="switch-target active">
          <h4>Lovely! Upload it here:</h4>
          <div class="upload-box initial">
            <div class="uploaded-files"></div>
            <div class="drop-label">Drag &amp; drop files here <span>or</span></div>
            <a href="#" class="add-files">browse files!</a>
            <a href="#" class="upload">upload files</a>
            <span class="file-size">0 MB of 100 MB</span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="left">
        <h4>Have a project deadline?</h4>
        <label class="radio" for="date1">
          No specific date in mind.
          <input type="radio" id="date1" name="deadline" class="input-switch" data-switchto="no-date" checked>
          <span class="control-indicator"></span>
        </label>
        <label class="radio" for="date2">
          Yes, I have a specific date in mind.
          <input type="radio" id="date2" name="deadline" class="input-switch" data-switchto="datepicker">
          <span class="control-indicator"></span>
        </label>
      </div>
      <div class="right">
        <div id="no-date" class="switch-target active">
          <h4>Cool We’ll work with you to Plan a Launch date</h4>
          <p>Every project is different. We’ll work with you to plan consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
        </div>
        <div id="datepicker" class="switch-target">
          <a href="#" class="datepicker">Pick a Date</a>
          <div class="date-input">
            <input type="text" value="Select a Date">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="left">
        <label for="budget">Have a project budget?*</label>
        <p>Please select the budget range you are most comfortable with.</p>
      </div>
      <div class="right">
        <div class="select-box">
          <select name="budget" id="budget">
            <option value="">Select a Budget</option>
            <option value="$18,000-$30,000">$18,000-$30,000</option>
            <option value="$31,000-$45,000">$31,000-$45,000</option>
            <option value="$46,000-$60,000">$46,000-$60,000</option>
            <option value="$61,000+">$61,000+</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="full" data-text-align="center">
        <button type="submit" class="submit">Submit your request !</button>
      </div>
    </div>
  </form>

<?php $this->tplDisplay("inc_footer.php"); ?>
