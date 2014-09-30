<?php include('inc_header.php'); ?>

  <div class="row full">
    <div class="page-title">
      <h1>Work With Us</h1>
      <p class="subtitle">Let's start a dialogue. Just fill out the form below.</p>
    </div>
  </div>

  <form action="#" name="request-quote" class="request-quote-form">

    <div class="row full">
      <h2 class="form-title">Please tell us a lil&rsquo; about yourself</h2>
    </div>

    <div class="row">
      <div class="form-monkee">
        <div class="monkee"><div class="dark-monkee"></div></div>
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
          <span class="input-wrapper phone"><input type="tel" class="validate[required,custom[phone]]" id="phone"></span>
        </div>
        <label for="org">Organization</label>
        <div class="form-step">
          <span class="input-wrapper"><input type="text" class="org" id="org"></span>
        </div>
        <label for="url">Website URL</label>
        <div class="form-step">
          <span class="input-wrapper"><input type="text" class="url validate[custom[url]]" id="url"></span>
        </div>
      </div><!-- /.form-part1 -->
      <button type="submit" class="submit">Submit</button>
    </div>
  </form>

<?php include('inc_footer.php'); ?>
