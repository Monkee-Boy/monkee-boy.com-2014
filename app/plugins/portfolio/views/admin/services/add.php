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
            <span class="accordion-toggle">URLs</span>
          </div>
          <div id="pagecontent" class="accordion-body">
            <div class="accordion-inner">
              <div class="control-group">
                <label class="control-label" for="form-website">Website URL</label>
                <div class="controls">
                  <input type="text" name="website" id="form-website" value="<?php echo $aClient['website']; ?>" class="span12">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-website">Case Study URL</label>
                <div class="controls">
                  <input type="text" name="case_study" id="form-website" value="<?php echo $aClient['case_study']; ?>" class="span12">
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
                <label class="control-label" for="form-synopsis">Synopsis</label>
                <div class="controls">
                  <textarea name="synopsis" id="form-synopsis" class="span12" style="height:95px;"><?php echo $aClient['synopsis']; ?></textarea>
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-shortdescription">Listing Description</label>
                <div class="controls">
                  <textarea name="short_description" id="form-shortdescription" class="span12" style="height:95px;"><?php echo $aClient['short_description']; ?></textarea>
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-shortdescription">Other Services</label>
                <div class="controls">
                  <textarea name="other_services" id="form-shortdescription" class="span12" style="height:95px;"><?php echo $aClient['other_services']; ?></textarea>
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
            </div> <!--/.accordion-inner -->
          </div> <!-- /.accordion-body -->
        </div> <!-- /.accordion-group -->

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Services</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
            <?php foreach($aServices as $aService): ?>
              <h5><?php echo $aService['name']; ?></h5>
              <ul>
                <?php foreach($aService['subs'] as $aServiceSub): ?>
                <li><label><input type="checkbox" name="services[]" value="<?php echo $aServiceSub['id']; ?>"<?php echo ((in_array($aServiceSub['id'], $aClient['services']))?' checked="checked"':''); ?>><?php echo $aServiceSub['name']; ?></label></li>
                <?php endforeach; ?>
              </ul>
            <?php endforeach; ?>
            </div>
          </div> <!-- /.accordion-body -->
        </div> <!-- /.accordion-group -->

        <input type="submit" value="Create Client" class="btn btn-primary">
        <a href="/admin/portfolio/" title="Cancel" class="btn">Cancel</a>
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
                  <input type="checkbox" name="active" value="1"<?php echo (($aClient['active'] == 1)?' checked="checked"':''); ?>>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="form-logo">Featured</label>
                <div class="controls">
                  <input type="checkbox" name="featured" value="1"<?php echo (($aClient['featured'] == 1)?' checked="checked"':''); ?>>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="form-logo">App</label>
                <div class="controls">
                  <input type="checkbox" name="app" value="1"<?php echo (($aClient['app'] == 1)?' checked="checked"':''); ?>>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Media</span>
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

              <?php if(!empty($aClient['listing_image'])): ?>
                <div class="control-group photo-show">
                  <img src="<?php echo $imageFolder.$aClient['listing_image']; ?>" alt="Client Listing Image" style="max-width: 300px;"><br />
                  <a href="#">Replace Listing Image</a>
                </div>
              <?php endif; ?>

              <div class="control-group photo-upload"<?php if(!empty($aClient['listing_image'])){ echo ' style="display: none;"'; } ?>>
                <label class="control-label" for="form-listingimage">Listing Image</label>
                <div class="controls">
                  <input type="file" name="listing_image" id="form-listingimage">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
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
