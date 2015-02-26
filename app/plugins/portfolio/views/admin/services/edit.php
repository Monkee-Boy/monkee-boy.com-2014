<?php $this->tplDisplay("inc_header.php", ['menu'=>'services','sPageTitle'=>"Services &raquo; Manage Service"]); ?>

  <h2>Services &raquo; Manage Service</h2>
  <?php $this->tplDisplay('inc_alerts.php'); ?>

  <form id="add-form" method="post" action="/admin/portfolio/services/edit/s/" enctype="multipart/form-data">
    <div class="row-fluid">
      <div class="span8">

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Service Details</span>
          </div>
          <div id="pagecontent" class="accordion-body">
            <div class="accordion-inner">
              <div class="control-group">
                <label class="control-label" for="form-name">Name</label>
                <div class="controls">
                  <input type="text" name="name" id="form-name" value="<?php echo $aService['name']; ?>" class="span12 validate[required]">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-subtitle">Subtitle</label>
                <div class="controls">
                  <input type="text" name="subtitle" id="form-subtitle" value="<?php echo $aService['subtitle']; ?>" class="span12 validate[required]">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-subtitle">Subtitle 2</label>
                <div class="controls">
                  <input type="text" name="subtitle2" id="form-subtitle2" value="<?php echo $aService['subtitle2']; ?>" class="span12">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
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
                <label class="control-label" for="form-shortdescription">Description</label>
                <div class="controls">
                  <textarea name="description" id="form-shortdescription" class="span12" style="height:95px;"><?php echo $aService['description']; ?></textarea>
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
            </div> <!--/.accordion-inner -->
          </div> <!-- /.accordion-body -->
        </div> <!-- /.accordion-group -->

        <input type="hidden" name="id" value="<?php echo $aService['id']; ?>">
        <input type="submit" value="Save Changes" class="btn btn-primary">
        <a href="/admin/portfolio/services/" title="Cancel" class="btn">Cancel</a>
      </div>

      <div class="span4 aside">
        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Image</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <?php if(!empty($aService['image'])): ?>
                <div class="control-group photo-show">
                  <img src="<?php echo $aService['image_url']; ?>" alt="Service Image" style="max-width: 300px;"><br />
                  <a href="#">Replace Image</a>
                </div>
              <?php endif; ?>

              <div class="control-group photo-upload"<?php if(!empty($aService['image'])){ echo ' style="display: none;"'; } ?>>
                <label class="control-label" for="form-logo">Upload Image</label>
                <div class="controls">
                  <input type="file" name="image" id="form-logo">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">SEO</span>
          </div>
          <div id="pageseo" class="accordion-body">
            <div class="accordion-inner">
              <div class="control-group">
                <label class="control-label" for="form-tag">Title</label>
                <div class="controls">
                  <input type="text" name="seo_title" id="form-tags" value="<?= $aService['seo_title'] ?>" class="span12">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="form-tag">Description</label>
                <div class="controls">
                  <textarea name="seo_description" id="form-tags" style="height:95px;" class="span12"><?= $aService['seo_description'] ?></textarea>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="form-tag">Keywords</label>
                <div class="controls">
                  <textarea name="seo_keywords" id="form-tags" style="height:95px;" class="span12"><?= $aService['seo_keywords'] ?></textarea>
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
