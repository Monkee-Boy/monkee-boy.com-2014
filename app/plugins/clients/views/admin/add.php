<?php $this->tplDisplay("inc_header.php", ['menu'=>'clients','sPageTitle'=>"Clients &raquo; Create Client"]); ?>

  <h2>Clients &raquo; Create Client</h2>
  <?php $this->tplDisplay('inc_alerts.php'); ?>

  <form id="add-form" method="post" action="/admin/clients/add/s/" enctype="multipart/form-data">
    <div class="row-fluid">
      <div class="span8">

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Client Name</span>
          </div>
          <div id="pagecontent" class="accordion-body">
            <div class="accordion-inner">
              <div class="controls">
                <input type="text" name="name" id="form-name" value="<?= $aClient['name'] ?>" class="span12 validate[required]">
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Website</span>
          </div>
          <div id="pagecontent" class="accordion-body">
            <div class="accordion-inner">
              <div class="controls">
                <input type="text" name="website" id="form-title" value="<?= $aClient['website'] ?>" class="span12 validate[required]">
              </div>
            </div>
          </div>
        </div>

        <input type="submit" value="Create Client" class="btn btn-primary">
        <a href="/admin/clients/" title="Cancel" class="btn">Cancel</a>
      </div>

      <div class="span4 aside">

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Logo</span>
          </div>
          <div id="pageseo" class="accordion-body">
            <div class="accordion-inner">
              <?php if(!empty($aClient['logo'])): ?>
                <div class="control-group photo-show">
                  <img src="<?= $imageFolder.$aClient['logo'] ?>" alt="Client Image" style="max-width: 300px;"><br />
                  <a href="#">Replace Logo</a>
                </div>
              <?php endif; ?>

              <div class="control-group photo-upload"<?php if(!empty($aClient['logo'])){ echo ' style="display: none;"'; } ?>>
                <label class="control-label" for="form-tag">Upload Logo</label>
                <div class="controls">
                  <input type="file" name="logo">
                </div>
              </div>
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
