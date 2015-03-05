<?php $this->tplDisplay("inc_header.php", ['menu'=>'troop','sPageTitle'=>"Troop &raquo; Create Employee"]); ?>

  <h2>Troop &raquo; Create Employee</h2>
  <?php $this->tplDisplay('inc_alerts.php'); ?>

  <form id="add-form" method="post" action="/admin/troop/add/s/" enctype="multipart/form-data">
    <div class="row-fluid">
      <div class="span8">
        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">* Name</span>
          </div>
          <div id="pagecontent" class="accordion-body">
            <div class="accordion-inner">
              <div class="controls">
                <input type="text" name="name" id="form-name" value="<?= $aEmployee['name'] ?>" class="span12 validate[required]">
              </div>
            </div>
          </div>
        </div>
          <div class="accordion-group">
            <div class="accordion-heading">
              <span class="accordion-toggle">* Title</span>
            </div>
            <div id="pagecontent" class="accordion-body">
              <div class="accordion-inner">
                <div class="controls">
                  <input type="text" name="title" id="form-title" value="<?= $aEmployee['title'] ?>" class="span12 validate[required]">
                </div>
              </div>
            </div>
          </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Who?</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <div class="controls">
                <textarea name="who" class="span12"><?= $aEmployee['who'] ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">What?</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <div class="controls">
                <textarea name="what" class="span12"><?= $aEmployee['what'] ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">History</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <div class="controls">
                <textarea name="history" class="span12"><?= $aEmployee['history'] ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Quirk</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <div class="controls">
                <textarea name="quirk" class="span12"><?= $aEmployee['quirk'] ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Quote</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <div class="controls">
                <textarea name="quote" class="span12"><?= $aEmployee['quote'] ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <input type="submit" value="Create Employee" class="btn btn-primary">
        <a href="/admin/troop/" title="Cancel" class="btn">Cancel</a>
      </div>

      <div class="span4 aside">
        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Options</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <div class="control-group">
                <label class="control-label" for="form-logo">Active</label>
                <div class="controls">
                  <input type="checkbox" name="active" value="1"<?php echo (($aEmployee['active'] == 1)?' checked="checked"':''); ?>>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Main Photo</span>
          </div>
          <div id="pageseo" class="accordion-body">
            <div class="accordion-inner">
              <?php if(!empty($aEmployee['photo'])): ?>
                <div class="control-group photo-show">
                  <img src="<?= $imageFolder.$aEmployee['photo'] ?>" alt="Employee Image" style="max-width: 300px;"><br />
                  <a href="#">Replace Image</a>
                </div>
              <?php endif; ?>

              <div class="control-group photo-upload"<?php if(!empty($aEmployee['photo'])){ echo ' style="display: none;"'; } ?>>
                <label class="control-label" for="form-tag">Upload Photo</label>
                <div class="controls">
                  <input type="file" name="photo">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Hover Photo</span>
          </div>
          <div id="pageseo" class="accordion-body">
            <div class="accordion-inner">
              <?php if(!empty($aEmployee['photo_over'])): ?>
                <div class="control-group photo-show">
                  <img src="<?= $imageFolder.$aEmployee['photo_over'] ?>" alt="Employee Hover Image" style="max-width: 300px;"><br />
                  <a href="#">Replace Image</a>
                </div>
              <?php endif; ?>

              <div class="control-group photo-upload"<?php if(!empty($aEmployee['photo_over'])){ echo ' style="display: none;"'; } ?>>
                <label class="control-label" for="form-tag">Upload Photo</label>
                <div class="controls">
                  <input type="file" name="photo_over">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Social Accounts</span>
          </div>
          <div id="pageseo" class="accordion-body">
            <div class="accordion-inner">
              <?php
              foreach($aAccounts as $k=>$account): ?>
              <div class="control-group">
                <label class="control-label" for="form-tag"><?= $account ?></label>
                <div class="controls">
                  <input type="text" name="social_accounts[<?= $k ?>]" id="form-<?= $k ?>" value="<?= $aEmployee['social_accounts'][$k] ?>" class="span12">
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

{footer}
<script>
$(function(){
  jQuery('#add-form').validationEngine({ promptPosition: "bottomLeft" });

  $('.photo-show a').on('click', function(e) {
    e.preventDefault();
    $(this).hide();
    $(this).parent().next().show();
  });
});
</script>
{/footer}
<?php $this->tplDisplay("inc_footer.php"); ?>
