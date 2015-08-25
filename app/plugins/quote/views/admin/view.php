<?php $this->tplDisplay("inc_header.php", ['menu'=>'quote','sPageTitle'=>"Work With Us &raquo; Submission"]); ?>

  <h1>Work With Us &raquo; Submission</h1>
  <?php $this->tplDisplay('inc_alerts.php'); ?>

  <div class="row-fluid">
    <div class="span8">
      <div class="accordion-group">
        <div class="accordion-heading">
          <span class="accordion-toggle">Info</span>
        </div>
        <div id="pagecontent" class="accordion-body">
          <div class="accordion-inner">
            <div class="row-fluid">
              <div class="span6">
                <div class="control-group">
                  <label class="control-label" for="form-tag">Name</label>
                  <div class="controls"><?= $aQuote['name'] ?></div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="form-tag">Email</label>
                  <div class="controls"><?= $aQuote['email'] ?></div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="form-tag">Phone</label>
                  <div class="controls"><?= $aQuote['phone'] ?></div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="form-tag">Organization</label>
                  <div class="controls"><?= $aQuote['organization'] ?></div>
                </div>
              </div>

              <div class="span6">
                <div class="control-group">
                  <label class="control-label" for="form-tag">Website</label>
                  <div class="controls"><a href="<?= $aQuote['website'] ?>" target="_blank"><?= $aQuote['website'] ?></a></div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="form-tag">Deadline</label>
                  <div class="controls"><?= (!empty($aQuote['deadline']))?$aQuote['deadline']:'No deadline' ?></div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="form-tag">Budget</label>
                  <div class="controls"><?= $aQuote['budget'] ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php if(!empty($aQuote['brief'])): ?>
      <div class="accordion-group">
        <div class="accordion-heading">
          <span class="accordion-toggle">Brief</span>
        </div>
        <div class="accordion-body">
          <div class="accordion-inner">
            <div class="controls">
              <?= $aQuote['brief']; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <?php if(!empty($aQuote['main_service'])): ?>
      <div class="accordion-group">
        <div class="accordion-heading">
          <span class="accordion-toggle">Services</span>
        </div>
        <div class="accordion-body">
          <div class="accordion-inner">
            <div class="controls">
              <strong>Primary Service</strong>: <?= $aQuote['main_service']; ?><br />
              <strong>Service Option</strong>: <?= $aQuote['main_serviceoption']; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <?php if(!empty($aQuote['additional_services'])): ?>
      <div class="accordion-group">
        <div class="accordion-heading">
          <span class="accordion-toggle">Additional Services</span>
        </div>
        <div class="accordion-body">
          <div class="accordion-inner">
            <div class="controls">
              <?= $aQuote['additional_services']; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <?php if(!empty($aQuote['additional_info'])): ?>
      <div class="accordion-group">
        <div class="accordion-heading">
          <span class="accordion-toggle">Additional Info</span>
        </div>
        <div class="accordion-body">
          <div class="accordion-inner">
            <div class="controls">
              <?= $aQuote['additional_info']; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <?php if(!empty($aQuote['attachments'])): ?>
        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Attachments</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <div class="controls">
                <ul>
                  <?php foreach($aQuote['attachments'] as $name=>$file): ?>
                    <li><a href="/uploads/quote/<?= $file ?>" target="_blank"><?= htmlspecialchars(stripslashes($name)) ?></a></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <div class="span4 aside">
      <div class="accordion-group">
        <div class="accordion-heading">
          <span class="accordion-toggle">Details</span>
        </div>
        <div class="accordion-body">
          <div class="accordion-inner">
            <div class="control-group">
              <label class="control-label" for="form-tag">Submitted</label>
              <div class="controls"><?= date('m/d/Y g:ia', $aQuote['created_datetime']) ?></div>
            </div>

            <div class="control-group">
              <label class="control-label" for="form-tag">IP Address</label>
              <div class="controls"><?= $aQuote['ip'] ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php $this->tplDisplay("inc_footer.php"); ?>
