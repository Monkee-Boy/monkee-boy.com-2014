<?php $this->tplDisplay("inc_header.php", ['menu'=>'clients','sPageTitle'=>"Portfolio &raquo; Create Client"]); ?>

  <h2>Portfolio &raquo; Create Client</h2>
  <?php $this->tplDisplay('inc_alerts.php'); ?>

  <form id="add-form" method="post" action="/admin/portfolio/add/s/" enctype="multipart/form-data">
    <div class="row-fluid">
      <div class="span8">

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Client Details</span>
          </div>
          <div id="pagecontent" class="accordion-body">
            <div class="accordion-inner">
              <div class="control-group">
                <label class="control-label" for="form-name">Name</label>
                <div class="controls">
                  <input type="text" name="name" id="form-name" value="<?php echo $aClient['name']; ?>" class="span12 validate[required]">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
              <hr>

              <div class="control-group">
                <label class="control-label" for="form-website">Website URL</label>
                <div class="controls">
                  <input type="text" name="website" id="form-website" value="<?php echo $aClient['website']; ?>" class="span12">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
              <hr>

              <div class="control-group">
                <label class="control-label" for="form-subtitle">Subtitle</label>
                <div class="controls">
                  <input type="text" name="subtitle" id="form-subtitle" value="<?php echo $aClient['subtitle']; ?>" class="span12 validate[required]">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
              <hr>
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Content</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <div class="control-group">
                <label class="control-label" for="form-synopsis">Synopsis</label>
                <div class="controls">
                  <textarea name="synopsis" id="form-synopsis" class="span12" style="height:95px;"><?php echo $aClient['synopsis']; ?></textarea>
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
              <hr>

              <div class="control-group">
                <label class="control-label" for="form-shortdescription">Listing Description</label>
                <div class="controls">
                  <textarea name="short_description" id="form-shortdescription" class="span12" style="height:95px;"><?php echo $aClient['short_description']; ?></textarea>
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
              <hr>

              <div class="control-group">
                <label class="control-label" for="form-quote">Quote</label>
                <div class="controls">
                  <textarea name="synopsis" id="form-quote" class="span12" style="height:95px;"><?php echo $aClient['quote']; ?></textarea>
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
              <hr>
            </div> <!--/.accordion-inner -->
          </div> <!-- /.accordion-body -->
        </div> <!-- /.accordion-group -->

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Media</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <div class="control-group">
                <label class="control-label" for="form-listingimage">Listing Image</label>
                <div class="controls">
                  <input type="file" name="listing_image" id="form-listingimage">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
              <hr>

              <div class="control-group">
                <label class="control-label" for="form-anotherimage">Another Image</label>
                <div class="controls">
                  <input type="file" name="another_image" id="form-anotherimage">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
            </div> <!--/.accordion-inner -->
          </div> <!-- /.accordion-body -->
        </div> <!-- /.accordion-group -->

        <input type="submit" value="Create Client" class="btn btn-primary">
        <a href="/admin/portfolio/" title="Cancel" class="btn">Cancel</a>
      </div>

      <div class="span4 aside">

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Logo</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <?php if(!empty($aClient['logo'])): ?>
                <div class="control-group photo-show">
                  <img src="<?php echo $imageFolder.$aClient['logo']; ?>" alt="Client Logo" style="max-width: 300px;"><br />
                  <a href="#">Replace Logo</a>
                </div>
              <?php endif; ?>

              <div class="control-group photo-upload"<?php if(!empty($aClient['logo'])){ echo ' style="display: none;"'; } ?>>
                <label class="control-label" for="form-logo">Upload Logo</label>
                <div class="controls">
                  <input type="file" name="logo" id="form-logo">
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
